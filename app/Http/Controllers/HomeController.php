<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PenggunaModel;
use App\Models\TicketModel;
use App\Models\StatusModel;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class HomeController extends Controller
{
    public function dashboard()
    {
        if (!Session::has('loginId')) {
            return redirect('/')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = PenggunaModel::find(Session::get('loginId'));


        return view('Home');
    }

    public function getChartData(Request $request)
    {

        if ($request->filled(['tanggal_awal', 'tanggal_akhir'])) {
            $start = Carbon::parse($request->tanggal_awal)->startOfDay();
            $end = Carbon::parse($request->tanggal_akhir)->endOfDay();
            $isFilter = true;
        } else {

            $now = Carbon::now();
            $year = $now->year;

            if ($now->month <= 6) {
                $start = Carbon::create($year, 1, 1)->startOfDay();
                $end = Carbon::create($year, 6, 30)->endOfDay();
                $periodeText = 'Semester 1 (1 Januari – 30 Juni)';
            } else {
                $start = Carbon::create($year, 7, 1)->startOfDay();
                $end = Carbon::create($year, 12, 31)->endOfDay();
                $periodeText = 'Semester 2 (1 Juli – 31 Desember)';
            }

            $isFilter = false;
        }

        $rangeInDays = $start->diffInDays($end);


        if (!$isFilter) {
            $mode = 'monthly'; // semester
        } else {
            if ($rangeInDays <= 14) {
                $mode = 'daily';
            } elseif ($rangeInDays <= 60) {
                $mode = 'weekly';
            } else {
                $mode = 'monthly';
            }
        }

        $labels = [];
        $masukData = [];
        $keluarData = [];



        // DAILY
        if ($mode === 'daily') {
            $period = CarbonPeriod::create($start, $end);

            foreach ($period as $date) {
                $labels[] = $date->translatedFormat('d M');

                $masukData[] = TicketModel::whereDate('created_at', $date)->where('ticket.status_hapus', 0)->count();

                $keluarData[] = TicketModel::whereDate('created_at', $date)
                ->where('ticket.status_hapus', 0)
                    ->where('downtime', 1)
                    ->count();
            }

            $periodeText = $start->translatedFormat('d F Y') . ' – ' . $end->translatedFormat('d F Y');
        }

        // WEEKLY (REKOMENDASI UTAMA) 
        if ($mode === 'weekly') {
            $period = CarbonPeriod::create(
                $start->copy()->startOfWeek(),
                '1 week',
                $end->copy()->endOfWeek()
            );

            foreach ($period as $date) {
                $weekStart = $date->copy()->startOfWeek();
                $weekEnd = $date->copy()->endOfWeek();

                // CLAMP ke range filter
                if ($weekStart < $start)
                    $weekStart = $start->copy();
                if ($weekEnd > $end)
                    $weekEnd = $end->copy();

                $labels[] = $weekStart->translatedFormat('d M') . ' – ' . $weekEnd->translatedFormat('d M');

                $masukData[] = TicketModel::whereBetween('created_at', [$weekStart, $weekEnd])->where('ticket.status_hapus', 0)->count();

                $keluarData[] = TicketModel::whereBetween('created_at', [$weekStart, $weekEnd])->where('ticket.status_hapus', 0)
                    ->where('downtime', 1)
                    ->count();
            }

            $periodeText = $start->translatedFormat('d F Y') . ' – ' . $end->translatedFormat('d F Y');
        }

        // MONTHLY (SEMESTER / FILTER PANJANG)
        if ($mode === 'monthly') {
            $period = CarbonPeriod::create(
                $start->copy()->startOfMonth(),
                '1 month',
                $end->copy()->endOfMonth()
            );

            foreach ($period as $date) {
                $monthStart = $date->copy()->startOfMonth();
                $monthEnd = $date->copy()->endOfMonth();

                // CLAMP ke range filter
                if ($monthStart < $start)
                    $monthStart = $start->copy();
                if ($monthEnd > $end)
                    $monthEnd = $end->copy();

                $labels[] = $date->translatedFormat("M Y");

                $masukData[] = TicketModel::whereBetween('created_at', [$monthStart, $monthEnd])->where('ticket.status_hapus', 0)->count();

                $keluarData[] = TicketModel::whereBetween('created_at', [$monthStart, $monthEnd])->where('ticket.status_hapus', 0)
                    ->where('downtime', 1)
                    ->count();
            }

            if ($isFilter) {
                $periodeText = $start->translatedFormat('d F Y') . ' – ' . $end->translatedFormat('d F Y');
            }
        }


        // 4. RINGKASAN ANGKA
        if ($isFilter) {
            $totalMasuk = TicketModel::whereBetween('created_at', [$start, $end])->where('status_hapus', 0)->count();
            $totalKeluar = TicketModel::join('statuses', 'statuses.id_status', '=', 'ticket.id_status')
                ->whereBetween('ticket.created_at', [$start, $end])
                ->whereIn('statuses.urutan', [9, 12])->where('ticket.status_hapus', 0)->count();
            $OnProgres = TicketModel::join('statuses', 'statuses.id_status', '=', 'ticket.id_status')
                ->whereBetween('ticket.created_at', [$start, $end])
                ->whereNotIn('statuses.urutan', [9, 12])->where('ticket.status_hapus', 0)->count();

            $ticketnew = TicketModel::select(
                'ticket.id_ticket',
                'ticket.id_status',
                'statuses.nama_status',
                'statuses.urutan',
                'ticket.created_at'
            )
                ->selectRaw('DATE(ticket.created_at) as tanggal')
                ->join('statuses', 'statuses.id_status', '=', 'ticket.id_status')
                ->whereBetween('ticket.created_at', [$start, $end])
                ->whereNotIn('statuses.urutan', [9, 12])
                ->orderBy('ticket.created_at', 'desc') // tiket terbaru dulu
                ->where('ticket.status_hapus', 0)
                ->limit(15)
                ->get();
        } else {
            // DEFAULT: BULAN INI
            $totalMasuk = TicketModel::whereMonth('created_at', now()->month)->where('ticket.status_hapus', 0)
                ->whereYear('created_at', now()->year)->count();

            $totalKeluar = TicketModel::join('statuses', 'statuses.id_status', '=', 'ticket.id_status')
                ->whereMonth('ticket.created_at', now()->month)
                ->whereYear('ticket.created_at', now()->year)
                ->whereIn('statuses.urutan', [9, 12])->where('ticket.status_hapus', 0)->count();

            $OnProgres = TicketModel::join('statuses', 'statuses.id_status', '=', 'ticket.id_status')
                ->whereMonth('ticket.created_at', now()->month)
                ->whereYear('ticket.created_at', now()->year)
                ->whereNotIn('statuses.urutan', [9, 12])->where('ticket.status_hapus', 0)->count();

            $ticketnew = TicketModel::select(
                'ticket.id_ticket',
                'ticket.id_status',
                'statuses.nama_status',
                'statuses.urutan',
                'ticket.created_at'
            )
                ->selectRaw('DATE(ticket.created_at) as tanggal')
                ->join('statuses', 'statuses.id_status', '=', 'ticket.id_status')
                ->whereMonth('ticket.created_at', now()->month)
                ->whereYear('ticket.created_at', now()->year)
                ->whereNotIn('statuses.urutan', [9, 12])
                ->orderBy('created_at', 'desc') // tiket terbaru dulu
                ->where('ticket.status_hapus', 0)
                ->limit(15)
                ->get();
        }

        $ticketnew->transform(function ($item) {
            $item->created_at_formatted = Carbon::parse($item->created_at)
                ->isoFormat('dddd, D MMMM YYYY HH:mm');
            return $item;
        });


        // 5. RESPONSE
        return response()->json([
            'labels' => $labels,
            'masuk' => $masukData,
            'keluar' => $keluarData,
            'mode' => $mode,
            'periode' => $periodeText,
            'totalMasuk' => $totalMasuk,
            'totalKeluar' => $totalKeluar,
            'OnProgres' => $OnProgres,
            'ticketnew' => $ticketnew,

        ]);
    }
}