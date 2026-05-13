<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('penanganan', function (Blueprint $table) {
            $table->string('id_penanganan', 10)->primary();
            $table->unsignedBigInteger('id_ticket')->nullable()->index(); 
            $table->string('id_status', 10)->nullable()->index(); 
            $table->text('penanganan')->nullable();
            $table->string('id_pengguna', 10)->nullable()->index();
            $table->string('dokumentasi')->nullable(); 
            $table->timestamps();

            // Foreign key
            $table->foreign('id_ticket')
                ->references('id_ticket')
                ->on('ticket')
                ->onDelete('set null');

            $table->foreign('id_status')
                ->references('id_status')
                ->on('statuses')
                ->onDelete('set null');

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
        //
    }
};
