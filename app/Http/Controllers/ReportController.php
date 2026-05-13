<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TicketModel;
use App\Models\KategoriModel;
use Carbon\Carbon;

class ReportController extends Controller
{
    // Halaman report
    public function index()
    {
        $report = $this->getReportData();

        return view('Report.report', compact('report'));
    }

    // Filter AJAX berdasarkan tanggal
    public function filter(Request $request)
    {
        $start = $request->startDate;
        $end = $request->endDate;

        if (!$start || !$end) {
            return response()->json(['data' => []]);
        }

        $startDate = Carbon::parse($start)->startOfDay();
        $endDate = Carbon::parse($end)->endOfDay();

        $report = $this->getReportData($startDate, $endDate);

        return response()->json(['data' => $report]);
    }


    // Function untuk ambil report data
    private function getReportData($startDate = null, $endDate = null)
    {
        $kategoriList = KategoriModel::where('status_hapus', 0)->orderByRaw("CAST(SUBSTRING_INDEX(id_kategori, '-', -1) AS UNSIGNED) ASC")->get();
        $result = [];

        foreach ($kategoriList as $kategori) {

            $query = TicketModel::where('id_kategori', $kategori->id_kategori)->where('status_hapus', 0);

            if ($startDate !== null && $endDate !== null) {
                $query->whereBetween('ticket.created_at', [$startDate, $endDate]);
            }else{
                $query->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year);
            }

            $tickets = $query->get();

            // TOTAL TICKET
            $totalTicket = $tickets->count();

            // TOTAL AGING
            $totalAging = 0;

            foreach ($tickets as $t) {

                if ($t->updated_at) {
                    $totalAging += Carbon::parse($t->created_at)
                        ->diffInSeconds(Carbon::parse($t->updated_at)) / 3600;
                }
            }

            // AVERAGE AGING 
            $avgAging = $totalTicket > 0
                ? $totalAging / $totalTicket
                : 0;

            $result[] = [
                'kategori' => $kategori->nama_kategori,
                'total_ticket' => $totalTicket,
                'total_aging' => round($totalAging) . ' Jam',
                'avg_aging' => round($avgAging) . ' Jam',
            ];
        }

        return $result;
    }

}