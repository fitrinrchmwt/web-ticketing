<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusModel extends Model
{
    protected $table = 'statuses';
     protected $primaryKey = 'id_status';
     public $incrementing = false;
     public $keyType = 'string';
     public $timestamps = true;
     protected $fillable = [
          'id_status',
          'nama_status',
          'urutan',
          'status_hapus',
     ];

     public const CLOSED = 'Closed';

}
