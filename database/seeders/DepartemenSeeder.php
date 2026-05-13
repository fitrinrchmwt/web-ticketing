<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DepartemenModel;
use Illuminate\Support\Facades\DB;

class DepartemenSeeder extends Seeder
{
    public function run(): void
    {
        $departemenList = [
            'NOC'
            // 'MS',
            // 'OPJ & J',
            // 'Helpdesk',
            // 'E-GOV',
            // 'C-CARE',
            // 'JEPARA',
            // 'Sudirman Park'
        ];

        $lastDept = DepartemenModel::orderByRaw(
            "CAST(SUBSTRING(id_departemen, 5) AS UNSIGNED) DESC"
        )->first();

        $lastNumber = $lastDept
            ? (int) substr($lastDept->id_departemen, 4)
            : 0;

        foreach ($departemenList as $nama) {
            $lastNumber++;

            $kodeOtomatis = 'DEP-' . str_pad($lastNumber, 3, '0', STR_PAD_LEFT);

            DepartemenModel::updateOrCreate(
                ['id_departemen' => $kodeOtomatis],
                [
                    'nama_departemen' => $nama,
                    'status_hapus'    => 0,
                ]
            );
        }
    }
}
