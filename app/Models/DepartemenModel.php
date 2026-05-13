<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DepartemenModel extends Model
{
    protected $table = 'departemen';
     protected $primaryKey = 'id_departemen';
     public $incrementing = false;
     public $keyType = 'string';
     public $timestamps = false;
     protected $fillable = [
          'id_departemen',
          'nama_departemen',
          'status_hapus',
     ];
}
