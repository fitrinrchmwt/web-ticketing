<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('datapelanggan', function (Blueprint $table) {
            $table->id();
            $table->string('custNumber')->unique();
            $table->string('custName')->nullable()->index();
            $table->text('custAddress')->nullable();
            $table->string('custPhone')->nullable()->index();
            $table->string('custEmail')->nullable()->index();
            $table->string('custGroupId')->nullable()->index();
            $table->string('custProvince')->nullable();
            $table->string('custDistrict')->nullable();
            $table->string('custSubDistrict')->nullable();
            $table->string('custVillage')->nullable();
            $table->string('spCodeId')->nullable()->index();
            $table->string('spCode')->nullable();
            $table->boolean('status_hapus')->default(false)->index();
            
            $table->decimal('custLatitude', 10, 7)->nullable();
            $table->decimal('custLongitude', 10, 7)->nullable();

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('datapelanggan');
    }
};
