<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WaTemplate extends Model
{
    protected $table = 'wa_templates';

    protected $primaryKey = 'id_wa_tamplate';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_wa_tamplate',
        'name',
        'content',
        'status'
    ];
}
