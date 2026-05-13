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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();

            $table->string('custNumber', 20);
            $table->string('custName', 100);
            $table->text('custAddress');
            $table->string('custPhone', 20);
            $table->string('custEmail', 100)->nullable();
            $table->string('custGroupId', 50)->nullable();

            $table->string('custProvince', 50);
            $table->string('custDistrict', 50);
            $table->string('custSubDistrict', 50);
            $table->string('custVillage', 50);

            $table->string('spCodeId', 20);
            $table->string('spCode', 20);
            $table->string('servicename', 100);

            $table->decimal('custLatitude', 10, 7)->nullable();
            $table->decimal('custLongitude', 10, 7)->nullable();

            $table->boolean('is_real_number')->default(false);
            $table->enum('status', ['active', 'inactive'])->default('active');

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
