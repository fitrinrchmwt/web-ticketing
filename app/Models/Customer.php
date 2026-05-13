<?php

// app/Models/Customer.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

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
        'servicename',
        'custLatitude',
        'custLongitude',
        'is_real_number',
        'status',
    ];
}
