<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StatusModel;

class StatusSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            ['nama' => 'NEW',        'urutan' => 1],
            ['nama' => 'Open', 'urutan' => 2],
            ['nama' => 'Survey',     'urutan' => 3],
            ['nama' => 'PENJADWALAN',    'urutan' => 4],
            ['nama' => 'Install',      'urutan' => 5],
            ['nama' => 'Trial',      'urutan' => 6],
            ['nama' => 'Troubleshoot',      'urutan' => 7],
            ['nama' => 'Monitor',      'urutan' => 8],
            ['nama' => 'Review',      'urutan' => 9],
            ['nama' => 'Resolved',      'urutan' => 10],
            ['nama' => 'Deleted',      'urutan' => 11],
            ['nama' => 'Closed',      'urutan' => 12],
        ];

        // Ambil angka terbesar dari ST-XXX
        $lastStatus = StatusModel::selectRaw(
            "MAX(CAST(SUBSTRING(id_status, 4) AS UNSIGNED)) AS max_id"
        )->first();

        $lastNumber = $lastStatus->max_id ?? 0;

        foreach ($statuses as $status) {
            $lastNumber++;

            $kodeOtomatis = 'ST-' . str_pad($lastNumber, 3, '0', STR_PAD_LEFT);

            StatusModel::updateOrCreate(
                ['id_status' => $kodeOtomatis],
                [
                    'nama_status'  => $status['nama'],
                    'urutan'       => $status['urutan'],
                    'status_hapus' => 0,
                ]
            );
        }
    }
}
