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
        Schema::create('broadcast_outbox', function (Blueprint $table) {
            $table->id();
            $table->string('custNumber');
            $table->string('custName')->nullable();
            $table->string('custPhone')->nullable();

            $table->string('id_wa_tamplate')->nullable();
            $table->text('message');

            $table->timestamp('schedule_at')->nullable();
            $table->enum('status', ['pending', 'sent', 'failed'])->default('pending');

            $table->tinyInteger('status_hapus')->default(0);
            $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('broadcast_outbox');
    }
};
