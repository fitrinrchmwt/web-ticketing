<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    // Jalankan migration.

    public function up(): void
    {
        Schema::create('role', function (Blueprint $table) {
            $table->string('id_role', 10)->primary();
            $table->string('nama_role', 100);
            $table->tinyInteger('status_hapus')->default(0);
            $table->timestamps();
        });

        Schema::create('permission', function (Blueprint $table) {
            $table->string('id_permission', 10)->primary();
            $table->string('nama_permission', 100);
            $table->string('alias', 50);
            $table->timestamps();
        });

        Schema::create('role_permission', function (Blueprint $table) {
            $table->string('id_role', 10);
            $table->string('id_permission', 10);

            $table->primary(['id_role', 'id_permission']);

            $table->foreign('id_role')->references('id_role')->on('role')->onDelete('cascade');
            $table->foreign('id_permission')->references('id_permission')->on('permission')->onDelete('cascade');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('role');
    }
};
