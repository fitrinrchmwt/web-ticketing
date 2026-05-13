<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiCustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::query();


        if ($request->filled('service')) {
            $query->where('spCodeId', $request->service);
        }

        // cari nama/no
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('custName', 'like', '%' . $request->search . '%')
                  ->orWhere('custPhone', 'like', '%' . $request->search . '%');
            });
        }

        $customers = Customer::all();

        return response()->json([
            'status' => 'success',
            'data'   => $customers
        ]);
    }

    public function show($id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json([
                'message' => 'Customer tidak ditemukan'
            ], 404);
        }

        return response()->json($customer);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'custNumber'     => 'required|string|max:20|unique:customers,custNumber',
            'custName'       => 'required|string|max:255',
            'custAddress'    => 'required|string',
            'custPhone'      => 'required|string|max:20',
            'custEmail'      => 'required|email|unique:customers,custEmail',
            'custGroupId'    => 'nullable|string|max:50',
            'custProvince'   => 'nullable|string|max:100',
            'custDistrict'   => 'nullable|string|max:100',
            'custSubDistrict'=> 'nullable|string|max:100',
            'custVillage'    => 'nullable|string|max:100',
            'spCodeId'       => 'nullable|string|max:50',
            'spCode'         => 'nullable|string|max:50',
            'servicename'    => 'nullable|string|max:100',
            'custLatitude'   => 'nullable|string',
            'custLongitude'  => 'nullable|string',
            'is_real_number' => 'nullable|boolean',
            'status'         => 'nullable|string|max:20',
        ]);

        $customer = Customer::create($validated);

        return response()->json([
            'message' => 'Customer berhasil ditambahkan',
            'data'    => $customer
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json([
                'message' => 'Customer tidak ditemukan'
            ], 404);
        }

        $validated = $request->validate([
            'custNumber'     => 'required|string|max:20|unique:customers,custNumber,' . $id,
            'custName'       => 'required|string|max:255',
            'custAddress'    => 'required|string',
            'custPhone'      => 'required|string|max:20',
            'custEmail'      => 'required|email|unique:customers,custEmail,' . $id,
            'custGroupId'    => 'required|string',
            'custProvince'   => 'required|string',
            'custDistrict'   => 'required|string',
            'custSubDistrict'=> 'required|string',
            'custVillage'    => 'required|string',
            'spCodeId'       => 'required|string',
            'spCode'         => 'required|string',
            'servicename'    => 'required|string',
            'custLatitude'   => 'required|string',
            'custLongitude'  => 'required|string',
            'is_real_number' => 'required|boolean',
            'status'         => 'required|string',
        ]);

        $customer->update($validated);

        return response()->json([
            'message' => 'Customer berhasil diupdate',
            'data'    => $customer
        ]);
    }

    public function destroy($id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json([
                'message' => 'Customer tidak ditemukan'
            ], 404);
        }

        $customer->delete();

        return response()->json([
            'message' => 'Customer berhasil dihapus'
        ]);
    }
}