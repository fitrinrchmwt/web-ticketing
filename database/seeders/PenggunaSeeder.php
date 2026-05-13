<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PenggunaSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil ID role Admin
        $adminRoleId = DB::table('role')
            ->where('nama_role', 'Admin')
            ->value('id_role');

        if (! $adminRoleId) {
            return;
        }

        // Ambil departemen pertama (atau sesuaikan)
        $departemenId = DB::table('departemen')
            ->orderBy('id_departemen')
            ->value('id_departemen');

        // Cari ID pengguna terakhir
        $last = DB::table('pengguna')
            ->selectRaw("MAX(CAST(SUBSTRING(id_pengguna, 5) AS UNSIGNED)) AS max_id")
            ->first();

        $number = $last->max_id ?? 0;
        $number++;

        $idPengguna = 'PGN-' . str_pad($number, 2, '0', STR_PAD_LEFT);

        DB::table('pengguna')->updateOrInsert(
            ['username' => 'admin'],
            [
                'id_pengguna'   => $idPengguna,
                'id_departemen' => $departemenId,
                'id_role'       => $adminRoleId,
                'nama'          => 'Admin NOC',
                'email'         => 'admin@gmail.com',
                'password'      => Hash::make('121212'),
                'status_hapus'  => 0,
                'created_at'    => now(),
                'updated_at'    => now(),
            ]
        );
    }
}
