<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TemplateModel;
use Illuminate\Support\Facades\File;

class TemplateSeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('seeders/data/template.json');

        if (!File::exists($path)) {
            throw new \Exception("File template.json tidak ditemukan");
        }

        $json = json_decode(File::get($path), true);

        if (!isset($json['data'])) {
            throw new \Exception("Format JSON template tidak valid");
        }

        // Ambil angka terbesar dari TMP-XXX
        $last = TemplateModel::selectRaw(
            "MAX(CAST(SUBSTRING(id_template, 5) AS UNSIGNED)) AS max_id"
        )->first();

        $no = $last->max_id ?? 0;

        foreach ($json['data'] as $row) {
            $no++;

            $idTemplate = 'TMP-' . str_pad($no, 3, '0', STR_PAD_LEFT);
            
            TemplateModel::updateOrCreate(
                [
                    'id_template' => $idTemplate,
                ],
                [
                    'label_template'   => $row['label'], 
                    'isi_template' => html_entity_decode($row['isi_template']),
                    'status_hapus' => 0,
                ]
            );
        }
    }
}
