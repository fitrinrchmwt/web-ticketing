<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Broadcast extends Model
{
    protected $table = 'broadcast_outbox';

    protected $fillable = [
        'custNumber',
        'custName',
        'custPhone',
        'id_wa_tamplate',
        'message',
        'schedule_at',
        'status'
    ];

    // relasi ke tamplate wa
    public function waTemplate()
    {
        return $this->belongsTo(
            WaTemplate::class,
            'id_wa_tamplate',
            'id_wa_tamplate'
        );
    }
}