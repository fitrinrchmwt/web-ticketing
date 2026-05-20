<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use App\Models\DataPelanggan;

class PelangganController extends Controller
{

    public function data_pelanggan(Request $request)
    {
        $query = DataPelanggan::aktif();

        if ($request->filled('custName')) {
            $query->where('custName', 'like', '%' . $request->custName . '%');
        }

        if ($request->filled('custNumber')) {
            $query->where('custNumber', 'like', '%' . $request->custNumber . '%');
        }

        if ($request->filled('spCode')) {
            $query->where('spCode', $request->spCode);
        }

        $datapelanggan = $query
            ->orderBy('id', 'asc')
            ->paginate(10)
            ->withQueryString();

        $kodeLayanan = DataPelanggan::whereNotNull('spCode')
            ->select('spCode')
            ->distinct()
            ->orderBy('spCode')
            ->pluck('spCode');

        return view('data_pelanggan.pelanggan', compact('datapelanggan', 'kodeLayanan'));
    }

     public function sync()
    {
        $url = url('public/api/customers');
        // dd($url);

        $response = Http::timeout(60)->get($url);

        
        if (!$response->successful()) {
            return back()->with('error', 'Gagal mengambil data dari API.');
        }
        


        $data = $response->json()['data'] ?? [];

        foreach ($data as $item) {
            DataPelanggan::updateOrCreate(
                ['custNumber' => $item['custNumber']],
                [
                    'custName' => $item['custName'] ?? null,
                    'custAddress' => $item['custAddress'] ?? null,
                    'custPhone' => $item['custPhone'] ?? null,
                    'custEmail' => $item['custEmail'] ?? null,
                    'custGroupId' => $item['custGroupId'] ?? null,
                    'custProvince' => $item['custProvince'] ?? null,
                    'custDistrict' => $item['custDistrict'] ?? null,
                    'custSubDistrict' => $item['custSubDistrict'] ?? null,
                    'custVillage' => $item['custVillage'] ?? null,
                    'spCodeId' => $item['spCodeId'] ?? null,
                    'spCode' => $item['spCode'] ?? null,
                ]
            );
        }
        

        return back()->with('success', 'Sync data pelanggan selesai!');
    }


   public function show($custNumber)
    {
        $datapelanggan = DataPelanggan::where('custNumber', $custNumber)
            ->firstOrFail();

        return view('data_pelanggan.detail', compact('datapelanggan'));
    }



    
}