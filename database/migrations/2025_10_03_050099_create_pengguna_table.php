<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration.
     */
    public function up(): void
    {
        Schema::create('pengguna', function (Blueprint $table) {
            $table->string('id_pengguna', 10)->primary();
            $table->string('id_departemen', 10)->nullable()->index();
            $table->string('id_role', 10)->nullable()->index();
            $table->string('nama', 100)->nullable();
            $table->string('username', 100)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('password', 255);
            $table->tinyInteger('status_hapus')->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            // Relasi ke tabel departemen
            $table->foreign('id_departemen')
                ->references('id_departemen')
                ->on('departemen')
                ->onDelete('set null');

            // Relasi ke tabel role
            $table->foreign('id_role')
                ->references('id_role')
                ->on('role')
                ->onDelete('set null');
        });
    }

    /**
     * Batalkan migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengguna');
    }
};
