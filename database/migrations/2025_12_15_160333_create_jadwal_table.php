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
        Schema::create('jadwal', function (Blueprint $table) {
            $table->string('id_jadwal', 10)->primary();
            $table->unsignedBigInteger('id_ticket')->nullable()->index();
            $table->date('jadwal')->nullable(); 
            $table->string('id_pengguna', 10)->nullable()->index(); 
            $table->text('catatan')->nullable();
            $table->string('updated_by', 10)->nullable()->index(); 
            $table->timestamps();

            // Foreign key
            $table->foreign('id_ticket')
                ->references('id_ticket')
                ->on('ticket')
                ->onDelete('set null');

            $table->foreign('id_pengguna')
                ->references('id_pengguna')
                ->on('pengguna')
                ->onDelete('set null');

            $table->foreign('updated_by')
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
        Schema::dropIfExists('jadwal');
    }
};
