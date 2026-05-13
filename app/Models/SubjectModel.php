<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubjectModel extends Model
{
    protected $table = 'subject';
     protected $primaryKey = 'id_subject';
     public $incrementing = false;
     public $keyType = 'string';
     public $timestamps = true;
     protected $fillable = [
          'id_subject',
          'isi_subject',
          'status_hapus',
     ];
}
