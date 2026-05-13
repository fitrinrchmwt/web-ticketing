<?php

namespace App\Http\Controllers;

use App\Models\DataPelanggan;
use App\Models\CustTicketModel;
use Hamcrest\Arrays\IsArray;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\TicketModel;
use App\Models\SubjectModel;
use App\Models\KategoriModel;
use App\Models\LayananModel;
use App\Models\DeskripsiModel;
use App\Models\StatusModel;
use App\Models\PelangganModel;
use App\Models\PenggunaModel;
use App\Models\PenangananModel;
use App\Models\TemplateModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Models\JadwalModel;
use Carbon\Carbon;
use function Laravel\Prompts\select;

class TicketController extends Controller
{
    // 1. Menampilkan Dashboard Ticket
    public function dashboard()
    {
        Carbon::setLocale('id');

        $list_kategori = KategoriModel::where('status_hapus', 0)->get();
        $list_status = StatusModel::where('status_hapus', 0)->get();

        $response = Http::get('http://202.169.224.27:3004/api/v1/apps/allpackages');
        $list_layanan = $response->successful()
            ? ($response->json()['data'] ?? [])
            : [];

        return view('Ticket.Dashboard_Ticket', compact(
            'list_kategori',
            'list_status',
            'list_layanan'
        ));
    }




    // 2. Menampilkan Form Tambah Ticket
    public function create()
    {
        $unfinished_ticket = TicketModel::where('ticket.status_hapus', 0)
            ->whereNotIn('statuses.nama_status', ['Closed'])
            ->join('statuses', 'statuses.id_status', '=', 'ticket.id_status')
            ->count();
        $unfinished_bookmark_ticket = TicketModel::where('ticket.status_hapus', 0)
            ->where('bookmark', 1)
            ->whereNotIn('statuses.nama_status', ['Closed'])->whereNotIn('statuses.nama_status', ['closed'])
            ->join('statuses', 'statuses.id_status', '=', 'ticket.id_status')
            ->count();
        $list_subject = SubjectModel::select('id_subject', 'isi_subject')->where('status_hapus', 0)->get();
        $list_kategori = KategoriModel::select('id_kategori', 'nama_kategori')->where('status_hapus', 0)->get();
        $list_deskripsi = DeskripsiModel::select('id_deskripsi', 'label_deskripsi', 'deskripsi')->where('status_hapus', 0)->get();
        $list_status = StatusModel::select('id_status', 'nama_status')->where('status_hapus', 0)->get();



        //Tambahkan ini untuk ambil pengguna dengan role SPV
        $list_spv = PenggunaModel::join('role', 'role.id_role', '=', 'pengguna.id_role')
            ->where('role.nama_role', 'SPV')
            ->where('pengguna.status_hapus', 0)
            ->select('pengguna.id_pengguna', 'pengguna.nama')
            ->get();


        return view('Ticket.Form_Tambah', compact(
            'list_subject',
            'list_kategori',
            'list_deskripsi',
            'list_status',
            'unfinished_ticket',
            'unfinished_bookmark_ticket',
            'list_spv'
        ));


    }

    // 3. Menyimpan Ticket Baru
    public function store(Request $request)
    {

        // VALIDASI DASAR
        $request->validate([
            'id_ref' => 'nullable|exists:ticket,id_ticket',
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'subject' => 'required|string',
            'spCodeId' => 'required|string',
            'deskripsi' => 'required|string',
            'draft_id' => 'nullable|string',
            'id_status' => 'required|exists:statuses,id_status',
            'jenis' => 'required|in:0,1',
            'dispatcher' => 'nullable|array',
            'dispatcher.*' => 'exists:pengguna,id_pengguna',
        ]);


        // VALIDASI BERDASARKAN JENIS

        if ((int) $request->jenis === 1) {
            // Multi case
            $request->validate([
                'custNumber' => 'required|array|min:1',
                'custNumber.*' => 'required|string',
            ]);
        } else {
            // Single case
            $request->validate([
                'custNumber' => 'required|string',
            ]);
        }


        // TRANSACTION
        DB::transaction(function () use ($request) {

            $tanggal = $request->tanggal ?? now()->format('Y-m-d');
            $jam = $request->jam ?? now()->format('H:i');

            $ticket = TicketModel::create([
                'id_ref' => $request->id_ref,
                'subject' => $request->subject,
                'jenis' => (int) $request->jenis,
                'id_kategori' => $request->id_kategori,
                'id_pengguna' => auth()->id(),
                'spCodeId' => $request->spCodeId,
                'deskripsi' => $request->deskripsi,
                'id_status' => $request->id_status,
                'bookmark' => $request->has('bookmark'),
                'status_hapus' => 0,
                'alamat' => $request->alamat,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'waktu_gangguan' => "{$tanggal} {$jam}:00",
            ]);

            $draftId = $request->draft_id;

            if ($draftId) {
                $tempPath = "uploads/temp/ticket/{$draftId}";
                $finalPath = "uploads/ticket/deskripsi/{$ticket->id_ticket}";

                if (Storage::disk('public')->exists($tempPath)) {
                    // pindahkan folder
                    Storage::disk('public')->move($tempPath, $finalPath);

                    // update URL di deskripsi
                    $deskripsi = str_replace(
                        "/storage/uploads/temp/ticket/{$draftId}",
                        "/storage/uploads/ticket/deskripsi/{$ticket->id_ticket}",
                        $ticket->deskripsi
                    );

                    $ticket->update([
                        'deskripsi' => $deskripsi
                    ]);
                }
            }


            // CUSTOMER 
            if (is_array($request->custNumber)) {
                foreach ($request->custNumber as $i => $custNumber) {
                    CustTicketModel::create([
                        'id_ticket' => $ticket->id_ticket,
                        'custNumber' => $custNumber,
                        'custPhone' => $request->custPhone[$i],
                    ]);
                }
            } else {
                CustTicketModel::create([
                    'id_ticket' => $ticket->id_ticket,
                    'custNumber' => $request->custNumber,
                    'custPhone' => $request->custPhone,
                ]);
            }

            // DISPATCHER
            if ($request->filled('dispatcher')) {
                foreach ($request->dispatcher as $idPengguna) {
                    \App\Models\DispatcherModel::create([
                        'id_ticket' => $ticket->id_ticket,
                        'id_pengguna' => $idPengguna,
                    ]);
                }
            }
        });


        return redirect()
            ->route('ticket.dashboard')
            ->with('success', 'Ticket berhasil dibuat!');
    }

    // Menampilkan Halaman Update Ticket
    public function update(string $hash)
    {
        Carbon::setLocale('id');

        $id_ticket = decode_id($hash);

        $ticket = TicketModel::with(['customers', 'dispatchers'])->findOrFail($id_ticket);

        $ref_text = TicketModel::where('id_ticket', $ticket->id_ref)
            ->selectRaw("CONCAT('#', id_ticket, ' - ', subject) as text, id_ticket")
            ->first();


        $selectedDispatchers = $ticket->dispatchers
            ->pluck('id_pengguna')
            ->toArray();


        [$tanggal, $jam] = $this->splitDateTime($ticket->waktu_gangguan ?? $ticket->created_at);

        $id_status_closed = StatusModel::whereRaw('LOWER(nama_status) = ?', ['closed'])
            ->value('id_status');

        $closed = $ticket->id_status == $id_status_closed;

        [$tanggal_selesai, $jam_selesai] = $closed
            ? $this->splitDateTime($ticket->updated_at)
            : [null, null];

        $customers = CustTicketModel::where('cust_ticket.id_ticket', $id_ticket)
            ->join('datapelanggan as dp', 'dp.custNumber', '=', 'cust_ticket.custNumber')
            ->select(
                'dp.custNumber',
                'dp.custPhone',
                'dp.custName',
                'dp.spCode',
                'dp.spCodeId'
            )
            ->get();

        $tanggal_awal = Carbon::parse($ticket->created_at);

        $list_jadwal = $this->mapTimeline(
            JadwalModel::where('id_ticket', $id_ticket)
                ->join('pengguna as pic', 'jadwal.id_pengguna', '=', 'pic.id_pengguna')
                ->join('pengguna as updater', 'jadwal.updated_by', '=', 'updater.id_pengguna')
                ->select('jadwal.*', 'pic.nama as nama_pic', 'updater.nama as nama_updated_by')
                ->orderBy('jadwal.created_at')
                ->get(),
            $tanggal_awal
        );

        $list_penanganan = $this->mapTimeline(
            PenangananModel::where('id_ticket', $id_ticket)
                ->join('statuses', 'statuses.id_status', '=', 'penanganan.id_status')
                ->join('pengguna', 'pengguna.id_pengguna', '=', 'penanganan.id_pengguna')
                ->select('penanganan.*', 'statuses.nama_status', 'pengguna.nama')
                ->orderBy('penanganan.created_at')
                ->get(),
            $tanggal_awal
        );

        return view('Ticket.Update_Ticket', [
            'ticket' => $ticket,
            'ref_text' => $ref_text,
            'customers' => $customers,
            'selectedDispatchers' => $selectedDispatchers,
            'list_subject' => SubjectModel::where('status_hapus', 0)->get(),
            'list_kategori' => KategoriModel::where('status_hapus', 0)->get(),
            'list_deskripsi' => DeskripsiModel::where('status_hapus', 0)->get(),
            'list_status' => StatusModel::where('status_hapus', 0)->get(),
            'list_pengguna' => PenggunaModel::where('status_hapus', 0)->get(),
            'list_template' => TemplateModel::where('template.status_hapus', 0)
                ->select('template.*')
                ->get(),
            'list_spv' => PenggunaModel::join('role', 'role.id_role', '=', 'pengguna.id_role')
                ->where('role.nama_role', 'SPV')
                ->where('pengguna.status_hapus', 0)
                ->select('pengguna.id_pengguna', 'pengguna.nama')
                ->get(),
            'list_jadwal' => $list_jadwal,
            'list_penanganan' => $list_penanganan,
            'tanggal' => $tanggal,
            'jam' => $jam,
            'closed' => $closed,
            'tanggal_selesai' => $tanggal_selesai,
            'jam_selesai' => $jam_selesai,
        ]);
    }




    public function store_update(Request $request)
    {

        $validated = $request->validate([
            'id_ticket' => 'required|exists:ticket,id_ticket',
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'subject' => 'required|string',
            'spCodeId' => 'required|string',
            'deskripsi' => 'required|string',
            'jenis' => 'required|in:0,1',
            'custNumber' => 'required',
            'custNumber.*' => 'nullable',
            'dispatcher' => 'nullable|array',
            'dispatcher.*' => 'distinct|exists:pengguna,id_pengguna',
        ]);


        $id_ticket = $request->id_ticket;


        DB::transaction(function () use ($validated, $id_ticket, $request) {

            // UPDATE TICKET
            $ticket = TicketModel::findOrFail($id_ticket);
            $ticket->update([
                'subject' => $validated['subject'],
                'jenis' => (int) $validated['jenis'],
                'id_kategori' => $validated['id_kategori'],
                'spCodeId' => $validated['spCodeId'],
                'deskripsi' => $validated['deskripsi'],
                'bookmark' => $request->boolean('bookmark'),
                'downtime' => $request->boolean('downtime'),
                'alamat' => $request->alamat,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'status_hapus' => 0,
            ]);

            // SYNC CUSTOMER (PIVOT)
            $draftId = $request->draft_id;

            if ($draftId) {
                $tempPath = "uploads/temp/ticket/{$draftId}";
                $finalPath = "uploads/ticket/deskripsi/{$ticket->id_ticket}";

                if (Storage::disk('public')->exists($tempPath)) {
                    // pindahkan folder
                    Storage::disk('public')->move($tempPath, $finalPath);

                    // update URL di deskripsi
                    $deskripsi = str_replace(
                        "/storage/uploads/temp/ticket/{$draftId}",
                        "/storage/uploads/ticket/deskripsi/{$ticket->id_ticket}",
                        $ticket->deskripsi
                    );

                    $ticket->update([
                        'deskripsi' => $deskripsi
                    ]);
                }
            }

            CustTicketModel::where('id_ticket', $id_ticket)->delete();

            if (is_array($request->custNumber)) {
                foreach ($request->custNumber as $i => $custNumber) {
                    CustTicketModel::create([
                        'custNumber' => $custNumber,
                        'custPhone' => $request->custPhone[$i],
                        'id_ticket' => $id_ticket,
                    ]);
                }
            } else {
                CustTicketModel::create([
                    'custNumber' => $request->custNumber,
                    'custPhone' => $request->custPhone,
                    'id_ticket' => $id_ticket,
                ]);
            }
            
            // SYNC DISPATCHER (OPTIONAL)
            if (array_key_exists('dispatcher', $validated)) {
                \App\Models\DispatcherModel::where('id_ticket', $id_ticket)->delete();

                foreach ($validated['dispatcher'] as $id_pengguna) {
                    \App\Models\DispatcherModel::create([
                        'id_ticket' => $id_ticket,
                        'id_pengguna' => $id_pengguna,
                    ]);
                }
            }
        });

        return redirect()
            ->route('ticket.dashboard')
            ->with('success', 'Ticket berhasil diupdate!');
    }




    // 5. Halaman History Ticket
    public function history(string $hash)
    {
        Carbon::setLocale('id');
        $id_ticket = decode_id($hash);

        $ticket = TicketModel::with([
            'customers.customer',
            'status',
            'kategori',
            'pengguna',
            'historiPenanganan.status',
            'historiPenanganan.pengguna',
        ])->findOrFail($id_ticket);

        $tanggal_awal = Carbon::parse($ticket->created_at);

        // ATRIBUT TAMPILAN 
        $ticket->waktu_gangguan = optional(
            Carbon::parse($ticket->waktu_gangguan ?? $ticket->created_at)
        )->translatedFormat('d F Y H:i');

        $ticket->gangguan_solved = strtolower(optional($ticket->status)->nama_status) === strtolower('Closed')
            ? Carbon::parse($ticket->updated_at)->translatedFormat('d F Y H:i')
            : '-';

        $ticket->lokasi_gangguan = $ticket->alamat ?? '-';
        $ticket->lokasi_lat = $ticket->latitude ?? '-';
        $ticket->lokasi_long = $ticket->longitude ?? '-';
        $ticket->deskripsi_gangguan = $ticket->deskripsi;

        // CUSTOMER 
        $ticket->customer_list = $ticket->customers->map(fn($c) => [
            'custName' => $c->customer?->custName,
            'custPhone' => $c->customer?->custPhone,
            'spCode' => $c->customer?->spCode
        ]);

        // PENANGANAN TIMELINE 
        $list_penanganan = $this->mapTimeline(
            PenangananModel::where('id_ticket', $id_ticket)
                ->join('statuses', 'statuses.id_status', '=', 'penanganan.id_status')
                ->join('pengguna', 'pengguna.id_pengguna', '=', 'penanganan.id_pengguna')
                ->select('penanganan.*', 'statuses.nama_status', 'pengguna.nama')
                ->orderBy('penanganan.created_at')
                ->get(),
            $tanggal_awal
        );


        return view('Ticket.History_Ticket', compact('ticket', 'list_penanganan'));
    }



    // 6. fungsi untuk bookmark tiket
    public function bookmark(string $hash)
    {

        $id_ticket = decode_id($hash);
        $ticket = TicketModel::findOrFail($id_ticket);
        $ticket->bookmark = !$ticket->bookmark; // Toggle bookmark status
        $ticket->save();

        return redirect()->back()->with('success', 'Status bookmark tiket berhasil diperbarui!');
    }




    public function get_ticket_ref(Request $request)
    {
        $search = $request->search;
        $id_status_closed = StatusModel::where('nama_status', 'Closed')->orWhere('nama_status', 'closed')->value('id_status');

        $query = TicketModel::select(
            'ticket.id_ticket',
            DB::raw("CONCAT('#', ticket.id_ticket, ' - ', ticket.subject) as text"),
            'id_kategori'
        )->where('ticket.status_hapus', 0)->where('ticket.id_status', $id_status_closed);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('ticket.id_ticket', 'like', "%$search%")
                    ->orWhere('ticket.subject', 'like', "%$search%");
            });
        }

        return response()->json(
            $query->paginate(20)
        );
    }



    public function create_penanganan(Request $request)
    {
        $request->validate([
            'id_ticket' => 'required|exists:ticket,id_ticket',
            'id_status' => 'required|exists:statuses,id_status',
            'penanganan' => 'required',
        ]);

        $ticket = TicketModel::find($request->id_ticket);

        $lastPenanganan = PenangananModel::latest('id_penanganan')->first();
        $nextNumber = $lastPenanganan
            ? intval(substr($lastPenanganan->id_penanganan, 3)) + 1
            : 1;
        $id_penanganan = 'PEN' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);


        // Upload file jika ada
        $path = null;
        if ($request->hasFile('dokumentasi')) {
            $file = $request->file('dokumentasi');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('uploads/penanganan', $filename, 'public');
            //dd($path);
        }

        $penanganan = PenangananModel::create([
            'id_penanganan' => $id_penanganan,
            'id_ticket' => $request->id_ticket,
            'id_status' => $request->id_status,
            'penanganan' => $request->penanganan,
            'id_pengguna' => auth()->id(),
            'dokumentasi' => $path
        ]);

        $draftId = $request->draft_id;

        if ($draftId) {
            $tempPath = "uploads/temp/penanganan/{$draftId}";
            $finalPath = "uploads/penanganan/deskripsi/{$id_penanganan}";

            if (Storage::disk('public')->exists($tempPath)) {
                // pindahkan folder
                Storage::disk('public')->move($tempPath, $finalPath);

                // update URL di deskripsi
                $desk = str_replace(
                    "/storage/uploads/temp/penanganan/{$draftId}",
                    "/storage/uploads/penanganan/deskripsi/{$id_penanganan}",
                    $penanganan->penanganan
                );

                $penanganan->update([
                    'penanganan' => $desk
                ]);
            }
        }

        if ($request->id_status != $ticket->id_status) {
            $ticket->update(['id_status' => $request->id_status]);
        }


        return redirect()->back()->with('success', 'Penanganan tiket berhasil ditambahkan.');
    }

    //untuk upload gambar summernote
    public function uploadSummernote(Request $request)
    {
        $request->validate([
            'image' => 'image|max:2048',
            'draft_id' => 'required|string',
            'type' => 'required|in:ticket,penanganan',
        ]);

        try {
            $basePath = $request->type === 'ticket'
                ? 'uploads/temp/ticket'
                : 'uploads/temp/penanganan';

            $pathFolder = $basePath . '/' . $request->draft_id;

            $file = $request->file('image');
            $filename = uniqid('img_', true) . '.' . $file->getClientOriginalExtension();

            $path = $file->storeAs($pathFolder, $filename, 'public');

            return response()->json([
                'url' => asset('storage/' . $path)
            ]);

        } catch (\Throwable $e) {
            \Log::error('Upload Summernote gagal', [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => 'Gagal mengunggah gambar'
            ], 500);
        }
    }



    //fungsi untuk mengekstrak semua URL gambar dari HTML
    private function extractEditorImages(string $html): array
    {
        preg_match_all('/<img[^>]+src=["\']([^"\']+)["\']/', $html, $matches);
        return $matches[1] ?? [];
    }


    //fungsi untuk menghapus gambar penanganan yang tidak terpakai
    private function cleanupUnusedEditorImages(string $text, string $id, string $type): void
    {
        switch ($type) {
            case 'penanganan':
                $folder = 'uploads/penanganan/deskripsi/' . $id;
                break;
            case 'ticket':
                $folder = 'uploads/ticket/deskripsi/' . $id;
                break;
            default:
                break;
        }

        if (!Storage::disk('public')->exists($folder)) {
            return;
        }

        $usedImages = collect(
            $this->extractEditorImages($text)
        )->map(
                fn($url) =>
                str_replace(asset('storage') . '/', '', $url)
            );

        foreach (Storage::disk('public')->files($folder) as $file) {
            if (!$usedImages->contains($file)) {
                Storage::disk('public')->delete($file);
            }
        }
    }




    public function update_penanganan(Request $request)
    {
        $validated = $request->validate([
            'id_penanganan' => 'required|exists:penanganan,id_penanganan',
            'id_ticket' => 'required|exists:ticket,id_ticket',
            'id_status' => 'required|exists:statuses,id_status',
            'penanganan' => 'required',
            'dokumentasi' => 'nullable|file',
        ]);

        
        // TRANSACTION
        DB::transaction(function () use ($validated, $request) { //agar kalau ada error, semua proses dibatalkan

            $penanganan = PenangananModel::findOrFail($validated['id_penanganan']);
            $ticket = TicketModel::findOrFail($validated['id_ticket']);

            $path = $penanganan->dokumentasi;

            // Upload file baru
            if ($request->hasFile('dokumentasi')) {

                if ($path && Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }

                $file = $request->file('dokumentasi');
                $filename = now()->timestamp . '_' . str_replace(' ', '_', $file->getClientOriginalName());

                $path = $file->storeAs(
                    'uploads/penanganan',
                    $filename,
                    'public'
                );
            }

            // Bersihkan foto editor
            $this->cleanupUnusedEditorImages(
                $validated['penanganan'],
                $validated['id_penanganan'],
                'penanganan'
            );

            $penanganan->update([
                'id_status' => $validated['id_status'],
                'penanganan' => $validated['penanganan'],
                'id_pengguna' => auth()->id(),
                'dokumentasi' => $path,
            ]);


            $draftId = $request->draft_id;

            if ($draftId) {
                $tempPath = "uploads/temp/penanganan/{$draftId}";
                $finalPath = "uploads/penanganan/deskripsi/{$request->id_penanganan}";

                if (Storage::disk('public')->exists($tempPath)) {
                    // pindahkan folder
                    Storage::disk('public')->move($tempPath, $finalPath);

                    // update URL di deskripsi
                    $desk = str_replace(
                        "/storage/uploads/temp/penanganan/{$draftId}",
                        "/storage/uploads/penanganan/deskripsi/{$request->id_penanganan}",
                        $penanganan->penanganan
                    );

                    $penanganan->update([
                        'penanganan' => $desk
                    ]);
                }
            }

            if ($ticket->id_status !== $validated['id_status']) {
                $ticket->update(['id_status' => $validated['id_status']]);
            }
        });

        return redirect()->back()->with('success', 'Penanganan tiket berhasil diperbarui.');
    }



    // AJAX LIST TICKET & FILTER
    public function list_ticket(Request $request)
    {
        $query = TicketModel::query()
            ->where('ticket.status_hapus', 0)
            ->join('kategori', 'kategori.id_kategori', '=', 'ticket.id_kategori')
            ->join('statuses', 'statuses.id_status', '=', 'ticket.id_status')
            ->leftJoin('pengguna', 'pengguna.id_pengguna', '=', 'ticket.id_pengguna')
            ->select(
                'ticket.*'
            );



        $id_status_closed = StatusModel::where('nama_status', 'Closed')->orWhere('nama_status', 'closed')->value('id_status');

        switch ($request->tab) {
            case 'bookmark':
                $query->where('ticket.bookmark', 1);
                break;
            case 'history':
                $query->where('ticket.id_status', $id_status_closed);
                break;
            case 'unfinished':
                $query->where('ticket.id_status', '!=', $id_status_closed);
                break;
            case 'bookmarkUnfinished':
                $query->where('ticket.bookmark', 1)->where('ticket.id_status', '!=', $id_status_closed);
                break;
            default:
                break;
        }



        // SEARCH
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('ticket.id_ticket', 'like', "%{$request->search}%")
                    ->orWhere('ticket.subject', 'like', "%{$request->search}%")
                    ->orWhereHas('customers', function ($cq) use ($request) {
                        $cq->where('custNumber', 'like', "%{$request->search}%");
                    })
                    ->orWhereHas('pengguna', function ($p) use ($request) {
                        $p->where('nama', 'like', "%{$request->search}%");
                    });
            });
        }

        // FILTER STATUS
        if ($request->status) {
            $query->where('ticket.id_status', $request->status);
        }
        // FILTER KATEGORI
        if ($request->kategori) {
            $query->where('ticket.id_kategori', $request->kategori);
        }

        // FILTER LAYANAN
        if ($request->layanan) {
            $query->where('ticket.spCodeId', $request->layanan);
        }

        // FILTER TANGGAL
        if ($request->tgl_mulai) {
            $query->whereDate('ticket.created_at', '>=', $request->tgl_mulai);
        }

        if ($request->tgl_akhir) {
            $query->whereDate('ticket.created_at', '<=', $request->tgl_akhir);
        }

        // FILTER JENIS
        if ($request->jenis !== null) {
            $query->where('ticket.jenis', $request->jenis);
        }

        return response()->json(
            $query->orderBy('ticket.created_at', 'desc')
                ->paginate($request->per_page ?? 10)
        );
    }


    public function destroy(string $hash)
    {

        $id_ticket = decode_id($hash);
        $ticket = TicketModel::findOrFail($id_ticket);
        $ticket->status_hapus = 1;
        $ticket->save();

        return redirect()->back()->with('success', 'Ticket berhasil dihapus.');
    }


    public function get_customers(Request $request)
    {
        $query = DataPelanggan::query();

        $q = $request->q;

        $query->where(function ($x) use ($q) {
            $x->where('custName', 'like', "%{$q}%")
                ->orWhere('custNumber', 'like', "%{$q}%");
        });


        return response()->json(
            $query->paginate(20)
        );
    }



    public function create_jadwal(Request $request)
    {
        try {
            $request->validate([
                'id_ticket' => 'required|exists:ticket,id_ticket',
                'jadwal' => 'required',
                'id_pengguna' => 'required|exists:pengguna,id_pengguna',
                'catatan' => 'required',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            
        }

        $ticket = TicketModel::find($request->id_ticket);

        $lastJadwal = JadwalModel::latest('id_jadwal')->first();
        $nextNumber = $lastJadwal
            ? intval(substr($lastJadwal->id_jadwal, 3)) + 1
            : 1;
        $id_jadwal = 'JAD' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);



        $updated_by = auth()->id();

        JadwalModel::create([
            'id_jadwal' => $id_jadwal,
            'id_ticket' => $request->id_ticket,
            'jadwal' => $request->jadwal,
            'id_pengguna' => $request->id_pengguna,
            'catatan' => $request->catatan,
            'updated_by' => $updated_by,
        ]);


        return redirect()->back()->with('success', 'Jadwal tiket berhasil ditambahkan.');
    }



    public function update_jadwal(Request $request)
    {
        $request->validate([
            'id_jadwal' => 'required|exists:jadwal,id_jadwal',
            'id_ticket' => 'required|exists:ticket,id_ticket',
            'jadwal' => 'required|date',
            'id_pengguna' => 'required|exists:pengguna,id_pengguna',
            'catatan' => 'required',
        ]);

        $jadwal = JadwalModel::findOrFail($request->id_jadwal);
        $ticket = TicketModel::findOrFail($request->id_ticket);

        $updated_by = auth()->id();

        $jadwal->update([
            'id_ticket' => $request->id_ticket,
            'jadwal' => $request->jadwal,
            'id_pengguna' => $request->id_pengguna,
            'catatan' => $request->catatan,
            'updated_by' => $updated_by,
        ]);

        return redirect()->back()->with('success', 'Jadwal tiket berhasil diperbarui.');
    }


   
    // HELPER

    private function splitDateTime(?string $datetime): array
    {
        if (!$datetime) {
            return [null, null];
        }

        $dt = Carbon::parse($datetime);
        return [$dt->toDateString(), $dt->format('H:i')];
    }


    private function mapTimeline($items, Carbon $start)
    {
        $current = clone $start;

        return $items->map(function ($item) use (&$current) {
            $created = Carbon::parse($item->created_at);
            $updated = Carbon::parse($item->updated_at);

            $item->tanggal_proses =
                $current->translatedFormat('d F Y H:i')
                . ' - '
                . $created->translatedFormat('d F Y H:i');

            $item->created_at_formatted = $created->translatedFormat('l, d F Y H:i');
            $item->updated_at_formatted = $updated->translatedFormat('l, d F Y H:i');

            $current = $created;

            return $item;
        });
    }

}