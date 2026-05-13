<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataPelanggan extends Model
{
    protected $table = 'datapelanggan';

    protected $fillable = [
        'custNumber',
        'custName',
        'custAddress',
        'custPhone',
        'custEmail',
        'custGroupId',
        'custProvince',
        'custDistrict',
        'custSubDistrict',
        'custVillage',
        'spCodeId',
        'spCode',
        'status_hapus'
    ];

    protected $casts = [
        'status_hapus' => 'boolean',
    ];

    public function scopeAktif($query)
    {
        return $query->where('status_hapus', 0);
    }

    public function scopeSearch($query, $keyword)
    {
        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('custName', 'like', "%{$keyword}%")
                  ->orWhere('custPhone', 'like', "%{$keyword}%")
                  ->orWhere('custEmail', 'like', "%{$keyword}%")
                  ->orWhere('custNumber', 'like', "%{$keyword}%");
            });
        }
    }
}
