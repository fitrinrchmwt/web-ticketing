<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AuthModel;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;

class LayananController extends Controller
{
    
    public function kelola_layanan()
    {
       $response = Http::get('http://202.169.224.27:3004/api/v1/apps/allpackages');

        if ($response->successful()) {
            $hasil = $response->json();

            // Kalau API ada key "data"
            $datalayanan = $hasil['data'] ?? [];
        } else {
            $datalayanan = [];
        }

        return view('Kelola_Layanan.Kelola_Layanan', compact('datalayanan'));
    }

    

}
