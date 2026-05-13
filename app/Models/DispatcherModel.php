<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DispatcherModel extends Model
{
    protected $table = 'dispatchers';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $keyType = 'int';
    public $timestamps = true;

    protected $fillable = [
        'id_ticket',
        'id_pengguna',
    ];
}
