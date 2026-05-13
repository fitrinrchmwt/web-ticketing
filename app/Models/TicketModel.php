<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketModel extends Model
{
    protected $table = 'ticket';
    protected $primaryKey = 'id_ticket';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'id_ticket',
        'id_ref',
        'subject',
        'id_status',
        'id_kategori',
        'id_pengguna',
        'spCodeId',
        'deskripsi',
        'bookmark',
        'downtime',
        'alamat',
        'latitude',
        'longitude',
        'waktu_gangguan',
        'jenis',
        'status_hapus',
    ];


    protected $appends = [
        'hash_id',
        'customer_numbers',
        'aging_display',
        'aging_color',
        'aging_icon',
        'last_handler_name',
        'total_replies',
        'created_at_formatted',
        'updated_at_formatted',
    ];


    public function customers()
    {
        return $this->hasMany(CustTicketModel::class, 'id_ticket', 'id_ticket');
    }


    public function historiPenanganan()
    {
        return $this->hasMany(PenangananModel::class, 'id_ticket', 'id_ticket');
    }

    public function lastPenanganan()
    {
        return $this->hasOne(
            PenangananModel::class,
            'id_ticket',
            'id_ticket'
        )->latest('created_at');
    }

    public function pengguna()
    {
        return $this->belongsTo(PenggunaModel::class, 'id_pengguna', 'id_pengguna');
    }



    public function dispatchers()
    {
        return $this->hasMany(DispatcherModel::class, 'id_ticket', 'id_ticket');
    }

    public function status()
    {
        return $this->belongsTo(StatusModel::class, 'id_status', 'id_status');
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriModel::class, 'id_kategori', 'id_kategori');
    }



    public function getHashIdAttribute(): ?string
    {
        if (!isset($this->id_ticket)) {
            return null;
        }

        return encode_id((int) $this->id_ticket);
    }



    public function getCustomerNumbersAttribute()
    {
        return $this->customers
            ->pluck('custNumber')
            ->implode(', ');
    }


    public function getAgingTicketAttribute(): int
    {
        $created = \Carbon\Carbon::parse($this->created_at);

        $end = in_array(optional($this->status)->nama_status, ['Closed', 'closed'])
            ? \Carbon\Carbon::parse($this->updated_at)
            : now();

        return $created->diffInMinutes($end);
    }


    public function getAgingDisplayAttribute(): string
    {
        $minutes = $this->aging_ticket;

        if ($minutes < 60) {
            return $minutes . ' menit';
        }

        return intdiv($minutes, 60) . ' jam';
    }




    public function getAgingColorAttribute(): string
    {
        $minutes = $this->aging_ticket;

        if ($minutes < 120) {
            return 'text-success'; // < 1 jam
        }

        if ($minutes <= 240) { // 4 jam
            return 'text-warning';
        }

        return 'text-danger';
    }



    public function getAgingIconAttribute(): string
    {
        $minutes = $this->aging_ticket;

        if ($minutes < 120) {
            return asset('/storage/awal.png');
        }

        if ($minutes <= 240) {
            return asset('/storage/onprogress.png');
        }

        return asset('/storage/silang.png');
    }


    public function getTotalRepliesAttribute()
    {
        return $this->historiPenanganan->count();
    }


    public function getLastHandlerNameAttribute()
    {
        return $this->lastPenanganan
            ?->pengguna
                ?->nama ?? $this->pengguna?->nama;
    }



    public function getCreatedAtFormattedAttribute()
    {
        return \Carbon\Carbon::parse($this->created_at)
            ->translatedFormat('l, d F Y H:i');
    }

    public function getUpdatedAtFormattedAttribute()
    {
        return \Carbon\Carbon::parse($this->updated_at)
            ->translatedFormat('l, d F Y H:i');
    }



}