<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            DepartemenSeeder::class,
            StatusSeeder::class,
            KategoriSeeder::class,
            SubjectSeeder::class,
            DeskripsiSeeder::class,
            TemplateSeeder::class,
            RoleSeeder::class,
            PermissionSeeder::class,
            RolePermissionSeeder::class,
            PenggunaSeeder::class,
            CustomerSeeder::class,
        ]);
    }
}
