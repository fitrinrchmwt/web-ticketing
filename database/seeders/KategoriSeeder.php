<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriModel;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategoriList = [
            'Keluhan Billing',
            'Keluhan Network',
            'Keluhan NOC',
            'Keluhan Helpdesk',
            'Keluhan POP JEPARA',
            'Keluhan EGOV',
            'Keluhan POP SUDIRMAN PARK',
            'Update C-CARE',
        ];

        // Ambil angka terbesar dari KTG-XXX (AMAN)
        $lastKategori = KategoriModel::selectRaw(
            "MAX(CAST(SUBSTRING(id_kategori, 5) AS UNSIGNED)) AS max_id"
        )->first();

        $lastNumber = $lastKategori->max_id ?? 0;

        foreach ($kategoriList as $nama) {
            $lastNumber++;

            $kodeOtomatis = 'KTG-' . str_pad($lastNumber, 3, '0', STR_PAD_LEFT);

            KategoriModel::updateOrCreate(
                ['id_kategori' => $kodeOtomatis],
                [
                    'nama_kategori' => $nama,
                    'status_hapus' => 0,
                ]
            );
        }
    }
}
