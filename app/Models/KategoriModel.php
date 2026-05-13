<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriModel extends Model
{
    protected $table = 'kategori';
     protected $primaryKey = 'id_kategori';
     public $incrementing = false;
     public $keyType = 'string';
     public $timestamps = false;
     protected $fillable = [
          'id_kategori',
          'nama_kategori',
          'status_hapus',
     ];
}
