<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $rolePermissions = [
            'Admin' => [
                'dashboard',
                'report',
                'data_master',
                'ticket',
                'data_pelanggan',
                'broadcast',
            ],
            'Helpdesk' => [
                'dashboard',
                'ticket',
                'broadcast',
                'report',
            ],
            'SPV' => [
                'dashboard',
                'ticket',
                'broadcast',
            ],
            'Staff' => [
                'dashboard',
                'ticket',
            ],
        ];

        foreach ($rolePermissions as $roleName => $permissions) {

            $roleId = DB::table('role')
                ->where('nama_role', $roleName)
                ->value('id_role');

            if (! $roleId) {
                continue; // role belum ada → jangan sok insert
            }

            foreach ($permissions as $permName) {

                $permId = DB::table('permission')
                    ->where('nama_permission', $permName)
                    ->value('id_permission');

                if (! $permId) {
                    continue;
                }

                DB::table('role_permission')->updateOrInsert(
                    [
                        'id_role'       => $roleId,
                        'id_permission' => $permId,
                    ],
                    [
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }
    }
}
