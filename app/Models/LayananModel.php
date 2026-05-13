<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LayananModel extends Model
{
    protected $table = 'layanan';
    protected $primaryKey = 'id_layanan';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_layanan', 'id_departemen','kode_layanan', 'jenis_layanan', 'status_hapus'
    ];

    public $timestamps = false;
}
