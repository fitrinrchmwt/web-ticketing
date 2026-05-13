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
        Schema::table('ticket', function (Blueprint $table) {
            $table->boolean('bookmark')->default(false)->after('deskripsi');
            $table->boolean('downtime')->default(false)->after('bookmark');
            $table->text('alamat')->nullable()->after('bookmark');
            $table->decimal('latitude', 10, 7)->nullable()->after('alamat');
            $table->decimal('longitude', 10, 7)->nullable()->after('latitude');
            $table->timestamp('waktu_gangguan')->nullable()->after('longitude');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ticket', function (Blueprint $table) {
            $table->dropColumn('bookmark');
            $table->dropColumn('alamat');
            $table->dropColumn('latitude');
            $table->dropColumn('longitude');
            $table->dropColumn('waktu_gangguan');
        });
    }
};
