<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            ['nama_permission' => 'dashboard',      'alias' => 'Dashboard'],
            ['nama_permission' => 'report',         'alias' => 'Report'],
            ['nama_permission' => 'data_master',    'alias' => 'Data Master'],
            ['nama_permission' => 'ticket',         'alias' => 'Ticket'],
            ['nama_permission' => 'data_pelanggan', 'alias' => 'Data Pelanggan'],
            ['nama_permission' => 'broadcast',      'alias' => 'Broadcast'],
        ];

        $last = DB::table('permission')
            ->selectRaw("MAX(CAST(SUBSTRING(id_permission, 4) AS UNSIGNED)) AS max_id")
            ->first();

        $number = $last->max_id ?? 0;

        foreach ($permissions as $p) {
            $number++;

            DB::table('permission')->updateOrInsert(
                ['id_permission' => 'PR-' . str_pad($number, 2, '0', STR_PAD_LEFT)],
                [
                    'nama_permission' => $p['nama_permission'],
                    'alias'           => $p['alias'],
                    'created_at'      => now(),
                    'updated_at'      => now(),
                ]
            );
        }
    }
}
