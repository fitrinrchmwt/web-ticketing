<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SubjectModel;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        $subjects = [
            "[CHAT] - GANGGUAN INTERNET LAMBAT -",
            "[PHONE] - GANGGUAN INTERNET LAMBAT -",
            "[CHAT] - GANGGUAN APLIKASI ERROR -",
            "[PHONE] - GANGGUAN APLIKASI ERROR -",
            "[CHAT] - GANGGUAN WEBSITES ERROR -",
            "[PHONE] - GANGGUAN WEBSITES ERROR -",
            "[CHAT] - GANGGUAN CHANNEL TV -",
            "[PHONE] - GANGGUAN CHANNEL TV -",
            "[CHAT] - GANGGUAN PROSES BAYAR -",
            "[PHONE] - GANGGUAN PROSES BAYAR -",
            "[CHAT] - REAKTIVASI BILLING -",
            "[PHONE] - REAKTIVASI BILLING -",
            "[CHAT] - GANGGUAN INTERNET EGOV-",
            "[PHONE] - GANGGUAN INTERNET EGOV -",
            "[CHAT] - GANGGUAN TV EGOV-",
            "[PHONE] - GANGGUAN TV EGOV-",
            "[CHAT] - PEMASANGAN TV DIGITAL -",
            "[PHONE] - PEMASANGAN TV DIGITAL -",
            "[CHAT] - PEMINDAHAN PERANGKAT -",
            "[PHONE] - PEMINDAHAN PERANGKAT -",
            "[CHAT] - GANGGUAN INTERNET DC Critical Signal-",
            "[CHAT] - GANGGUAN INTERNET DC LOS-",
            "[CHAT] - GANGGUAN INTERNET DC DyingGasp-",
            "[CHAT] - GANGGUAN PERANGKAT ERROR -",
            "[CHAT] - GANGGUAN INTERNET DC NOC-",
            "[CHAT] - OPTIMALISASI LAYANAN -",
            "[CHAT] - GANGGUAN LAYANAN HOSPITALITY -",
            "[C-CARE] - PERUBAHAN DATA",
        ];

        // Ambil angka terbesar dari SUB-XXX secara numerik
        $last = SubjectModel::selectRaw(
            "MAX(CAST(SUBSTRING(id_subject, 5) AS UNSIGNED)) AS max_id"
        )->first();

        $lastNumber = $last->max_id ?? 0;

        foreach ($subjects as $text) {
            $lastNumber++;

            $kodeOtomatis = 'SUB-' . str_pad($lastNumber, 3, '0', STR_PAD_LEFT);

            SubjectModel::updateOrCreate(
                ['id_subject' => $kodeOtomatis],
                [
                    'isi_subject'  => $text,
                    'status_hapus' => 0,
                ]
            );
        }
    }
}
