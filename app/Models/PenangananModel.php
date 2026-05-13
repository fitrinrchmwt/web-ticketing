<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenangananModel extends Model
{
    protected $table = 'penanganan';
    protected $primaryKey = 'id_penanganan';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = [
        'id_penanganan',
        'id_ticket',
        'id_status',
        'penanganan',
        'id_pengguna',
        'dokumentasi',
    ];
    
    public function pengguna()
    {
        return $this->belongsTo(PenggunaModel::class, 'id_pengguna', 'id_pengguna');
    }

    public function status()
    {
        return $this->belongsTo(StatusModel::class, 'id_status', 'id_status');
    }

}
