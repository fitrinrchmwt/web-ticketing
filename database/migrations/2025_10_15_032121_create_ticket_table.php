<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ticket', function (Blueprint $table) {
            $table->id('id_ticket')->primary();
            $table->bigInteger('id_ref')->nullable()->index();
            $table->string('id_status',  10)->nullable()->index();
            $table->string('id_kategori', 10)->nullable()->index();
            $table->string('spCodeId', 50)->nullable();
            $table->string('id_pengguna', 10)->nullable()->index();
            $table->tinyInteger('jenis')->default(0);
            $table->text('subject')->nullable();
            $table->text('deskripsi')->nullable();
            $table->tinyInteger('status_hapus')->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            //Relasi ke tabel kategori
            $table->foreign('id_kategori')
                ->references('id_kategori')
                ->on('kategori')
                ->onDelete('set null'); 

            
            // Relasi ke tabel status
            $table->foreign('id_status')    
                ->references('id_status')
                ->on('statuses')
                ->onDelete('set null'); 

            // Relasi ke tabel pengguna
            $table->foreign('id_pengguna')
                ->references('id_pengguna')
                ->on('pengguna')
                ->onDelete('set null');

        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket');
    }
};
