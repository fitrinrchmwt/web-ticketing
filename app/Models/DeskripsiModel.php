<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeskripsiModel extends Model
{
    protected $table = 'deskripsi';
     protected $primaryKey = 'id_deskripsi';
     public $incrementing = false;
     public $keyType = 'string';
     public $timestamps = false;
     protected $fillable = [
          'id_deskripsi',
          'label_deskripsi',
          'deskripsi',
          'status_hapus',
     ];
}
