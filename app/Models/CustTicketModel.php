<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustTicketModel extends Model
{
    protected $table = 'cust_ticket';
    protected $primaryKey = 'id_cust_ticket';
    public $incrementing = true; 
    protected $fillable = [
        'custNumber',
        'custPhone',
        'id_ticket',
    ];

    public function customer()
    {
        return $this->belongsTo(DataPelanggan::class, 'custNumber', 'custNumber');
    }
}
