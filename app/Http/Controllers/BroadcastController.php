<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Broadcast;
use App\Models\DataPelanggan;
use App\Models\WaTemplate;

class BroadcastController extends Controller
{

    public function broadcast()
    {

        $kodeLayanan = DataPelanggan::whereNotNull('spCode')
            ->select('spCode')
            ->distinct()
            ->orderBy('spCode')
            ->pluck('spCode');

        $templates = WaTemplate::where('status', 'active')->get();

        return view('broadcast.broadcast', compact('kodeLayanan', 'templates'));
    }

    public function getDataPelanggan(Request $request)
    {
        $query = DataPelanggan::query();

        if ($request->layanan) {
            $query->where('spCode', $request->layanan);
        }

        // search
        if (!empty($request->search['value'])) {
            $search = $request->search['value'];

            $query->where(function ($q) use ($search) {
                $q->where('custNumber', 'like', "%{$search}%")
                    ->orWhere('custName', 'like', "%{$search}%")
                    ->orWhere('custPhone', 'like', "%{$search}%");
            });
        }

        $totalFiltered = $query->count();

        $start = $request->start ?? 0;
        $length = $request->length ?? 10;

        $data = $query
            ->orderBy('id')
            ->skip($start)
            ->take($length)
            ->get();

        return response()->json([
            'draw' => intval($request->draw),
            'recordsTotal' => DataPelanggan::count(),
            'recordsFiltered' => $totalFiltered,
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_wa_tamplate' => 'required|exists:wa_templates,id_wa_tamplate',
            'schedule_at' => 'required|date',
        ]);

        // 1. AMBIL TEMPLATE
        $template = WaTemplate::where(
            'id_wa_tamplate',
            $request->id_wa_tamplate
        )->firstOrFail();

        if (!$template->content) {
            return back()->withErrors('Isi template kosong');
        }

        if ($request->has('select_all')) {

            $pelanggan = DataPelanggan::when(
                $request->layanan,
                fn($q) => $q->where('spCode', $request->layanan)
            )->get();

        } else {

            if (empty($request->custNumber)) {
                return back()->withErrors('Pelanggan belum dipilih');
            }

            $pelanggan = DataPelanggan::whereIn(
                'custNumber',
                $request->custNumber
            )->get();
        }

        if ($pelanggan->isEmpty()) {
            return back()->withErrors('Data pelanggan tidak ditemukan');
        }

        // simpan ke outbox
        foreach ($pelanggan as $p) {
            Broadcast::create([
                'custNumber' => $p->custNumber,
                'custName' => $p->custName,
                'custPhone' => $p->custPhone,
                'id_wa_tamplate' => $template->id_wa_tamplate,
                'message' => $template->content, // STRING
                'schedule_at' => $request->schedule_at,
                'status' => 'pending',
            ]);
        }

        return back()->with('success', 'Broadcast berhasil disimpan');
    }

}