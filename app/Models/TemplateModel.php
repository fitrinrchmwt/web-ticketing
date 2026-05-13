<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TemplateModel extends Model
{
    protected $table = 'template';
    protected $primaryKey = 'id_template';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_template', 'label_template','isi_template', 'status_hapus'
    ];

    public $timestamps = false;
}
