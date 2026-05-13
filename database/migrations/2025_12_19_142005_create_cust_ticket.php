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
        Schema::create('cust_ticket', function (Blueprint $table) {
            $table->id('id_cust_ticket')->primary();
            $table->string('custNumber', 10)->nullable()->index();
            $table->string('custPhone', 15)->nullable();
            $table->unsignedBigInteger('id_ticket')->nullable()->index();
            $table->timestamps();

            // Relasi ke tabel ticket
            $table->foreign('id_ticket')
                ->references('id_ticket')
                ->on('ticket')
                ->onDelete('set null'); 

                
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cust_ticket');
    }
};
