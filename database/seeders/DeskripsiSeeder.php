<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DeskripsiModel;

class DeskripsiSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'label' => 'Permintaan Pemasangan TV',
                'deskripsi' => '<blockquote class="blockquote"><p><b>PEMASANGAN TV</b></p></blockquote><p><span style="font-size: 10px;"><i>Isi dengan data permintaan pelanggan</i></span></p><p>TV di lokasi sudah support layanan Digital</p>',
            ],
            [
                'label' => 'Permintaan Penggantian ONT',
                'deskripsi' => '<blockquote class="blockquote"><p><b>PENGGANTIAN ONT</b></p></blockquote><p><i><span style="font-size: 10px;">Check yang terjadi di lokasi pelanggan (tanda v)</span></i></p><p></p><table class="table table-bordered"><tbody><tr><td><span style="font-size: 14px;"><b>Perangkat</b></span></td><td><span style="font-size: 14px;"><b>STATUS</b></span></td><td><span style="font-size: 14px;"><b>CHECK (v)</b></span></td></tr><tr><td><span style="font-size: 10px;">ONT</span></td><td><span style="font-size: 10px;">Sering Restart</span></td><td><br></td></tr><tr><td><span style="font-size: 10px;">ONT</span></td><td><span style="font-size: 10px;">Sering Log Out</span></td><td><br></td></tr><tr><td><span style="font-size: 10px;">Adaptor ONT</span></td><td><span style="font-size: 10px;">Rusak</span></td><td><br></td></tr><tr><td><span style="font-size: 10px;">Wifi ONT</span></td><td><span style="font-size: 10px;">Sering Disable</span></td><td><br></td></tr><tr><td><br></td><td><br></td><td><br></td></tr></tbody></table><p></p>',
            ],
            [
                'label' => 'Keluhan LOS',
                'deskripsi' => '<blockquote class="blockquote"><p><span style="font-weight: bolder;">STATUS ONT (LOS)</span></p></blockquote><p><i style="font-size: 10.5px;">Capture Status ONT dari SMARTOLT</i><br></p><table class="table table-bordered" style="width: 1798.67px; color: rgb(33, 37, 41); background-color: rgb(255, 255, 255);"><tbody><tr><td><br></td></tr></tbody></table><p><br></p><p><br></p><blockquote class="blockquote"><p><span style="font-size: 18px; font-weight: bolder;">Catatan Lainnya</span></p></blockquote><p><span style="font-size: 10.5px;"><i>Isikan di bawah</i></span></p><p>[                                                                                                                                                                                              ]<br></p>',
            ],
            [
                'label' => 'Keluhan Power Failure/ DyingGasp',
                'deskripsi' => '<blockquote class="blockquote"><p><span style="font-weight: bolder;">STATUS ONT (POWER FAILURE)</span></p></blockquote><p><i style="font-size: 10.5px;">Capture Status ONT dari SMARTOLT</i><br></p><table class="table table-bordered" style="width: 1798.67px;"><tbody><tr><td><br></td></tr></tbody></table><p><br></p><p><br></p><blockquote class="blockquote"><p><span style="font-size: 18px; font-weight: bolder;">Catatan Lainnya</span></p></blockquote><p><span style="font-size: 10.5px;"><i>Isikan di bawah</i></span></p><p>[&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;]<br></p>',
            ],
            [
                'label' => 'Keluhan Lambat',
                'deskripsi' => '<<HTML PANJANG PERSIS DARI JSON KAMU – TIDAK DIPOTONG>>',
            ],
            [
                'label' => 'Status Billing dan Konfirmasi Billing',
                'deskripsi' => '<blockquote class="blockquote"><span style="font-weight: bolder; font-size: 1.25rem;">STATUS BILLING</span></blockquote><p><span style="font-size: 10px;"><i>Capture Status Billing SISTEM AKTIF / BLOKIR / TIDAK AKTIF</i></span></p><table class="table table-bordered" style="width: 596.828px;"><tbody><tr><td><br></td></tr></tbody></table><blockquote class="blockquote"><p><span style="font-weight: bolder;">KONFIRMASI BILLING</span></p></blockquote><p><span style="font-size: 10px;"><i>Capture Konfirmasi Billing</i></span></p><table class="table table-bordered" style="width: 1798.67px;"><tbody><tr><td><br></td></tr></tbody></table>',
            ],
            [
                'label' => 'Permintaan Pemindahan Perangkat',
                'deskripsi' => '<blockquote class="blockquote"><p><b>PEMINDAHAN PERANGKAT</b></p></blockquote><p><i><span style="font-size: 10px;">Check yang terjadi di lokasi pelanggan (tanda v)</span></i></p><table class="table table-bordered"><tbody><tr><td><b>Perangkat</b></td><td><b>STATUS</b></td><td><b>CHECK (v)</b></td></tr><tr><td>ONT</td><td><br></td><td><br></td></tr><tr><td>AP</td><td><br></td><td><br></td></tr></tbody></table>',
            ],
            [
                'label' => 'Keluhan NOC',
                'deskripsi' => '<p>ID :</p><p>root cause issue :</p><p>sinyal/transmit ont :</p><p>ip pelanggan :</p><p>versi ont :</p><p>ont bisa di remote :</p><p>sistem oprasi pelanggan :</p><p>versi aplikasi apabila ada :</p><p>paket langganan :</p><p>apakah paket sesuai :</p><p>lampiran SS whatsmyIP :</p><p>lampiran SS traceroute :</p><p>status aktif :</p><p>sudah coba di berapa device :</p><p>troubleshoot yang sudah di lakukan</p>',
            ],
        ];

        $last = DeskripsiModel::selectRaw(
            "MAX(CAST(SUBSTRING(id_deskripsi, 5) AS UNSIGNED)) AS max_id"
        )->first();

        $no = $last->max_id ?? 0;

        foreach ($items as $item) {
            $no++;
            $id = 'DES-' . str_pad($no, 3, '0', STR_PAD_LEFT);

            DeskripsiModel::updateOrCreate(
                ['label_deskripsi' => $item['label']],
                [
                    'id_deskripsi' => $id,
                    'deskripsi'    => $item['deskripsi'],
                    'status_hapus' => 0,
                ]
            );
        }
    }
}
