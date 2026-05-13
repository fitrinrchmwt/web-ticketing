<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RoleModel;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'Admin',
            'Helpdesk',
            'SPV',
            'Staff'
        ];

        // Ambil angka terbesar dari RL-XX secara numerik (AMAN)
        $lastRole = RoleModel::selectRaw(
            "MAX(CAST(SUBSTRING(id_role, 4) AS UNSIGNED)) AS max_id"
        )->first();

        $lastNumber = $lastRole->max_id ?? 0;

        foreach ($roles as $nama) {
            $lastNumber++;

            $kodeOtomatis = 'RL-' . str_pad($lastNumber, 2, '0', STR_PAD_LEFT);

            RoleModel::updateOrCreate(
                ['id_role' => $kodeOtomatis],
                [
                    'nama_role'   => $nama,
                    'status_hapus'=> 0,
                ]
            );
        }
    }
}
