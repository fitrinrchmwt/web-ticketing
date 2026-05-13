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
        Schema::create('statuses', function (Blueprint $table) {
            $table->string('id_status', 10)->primary(); // primary key custom (ku ubah string biar bisa pake format ST)
            $table->string('nama_status'); // nama status
            $table->integer('urutan'); // urutan status
            $table->tinyInteger('status_hapus')->default(0); // soft delete manual (0=aktif, 1=hapus)
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statuses');
    }
};
