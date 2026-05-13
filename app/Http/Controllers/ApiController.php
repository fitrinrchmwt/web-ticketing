<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getData()
    {
        
       return response()->json([
            "status" => "success",
            "data" => [
                ["spCodeId" => "life-style-300", "spName" => "Life Style 300", "spCode" => "Life Style 300", "spPrice" => 0],
                ["spCodeId" => "life---corp-120", "spName" => "Life - Corp 120", "spCode" => "Life - Corp 120", "spPrice" => 0],
                ["spCodeId" => "life-style-200", "spName" => "Life Style 200", "spCode" => "Life Style 200", "spPrice" => 0],
                ["spCodeId" => "life---corp-10", "spName" => "Life - Corp 10", "spCode" => "Life - Corp 10", "spPrice" => 0],
                ["spCodeId" => "life-style-10", "spName" => "Life Style 10", "spCode" => "Life Style 10", "spPrice" => 0],
                ["spCodeId" => "izzi-30", "spName" => "Izzi Life 30 Mbps", "spCode" => "IZZI 30", "spPrice" => 0],
                ["spCodeId" => "izzi-50", "spName" => "Izzi Life 50 Mbps", "spCode" => "IZZI 30", "spPrice" => 0],
                ["spCodeId" => "life-style-20", "spName" => "Life Style 20", "spCode" => "Life Style 20", "spPrice" => 0],
                ["spCodeId" => "life-style-50", "spName" => "Life Style 50", "spCode" => "Life Style 50", "spPrice" => 0],
                ["spCodeId" => "izzi-100", "spName" => "Izzi Life 100 Mbps", "spCode" => "IZZI 100", "spPrice" => 0],
                ["spCodeId" => "life-style---trusty-", "spName" => "Life Style - Trusty 30", "spCode" => "Life Style - Trusty", "spPrice" => 0],
                ["spCodeId" => "life-style-100", "spName" => "Life Style 100", "spCode" => "Life Style 100", "spPrice" => 0],
                ["spCodeId" => "izzi-200", "spName" => "Izzi Life 200 Mbps", "spCode" => "IZZI 200", "spPrice" => 0],
            ]
        ]);
    }
}
