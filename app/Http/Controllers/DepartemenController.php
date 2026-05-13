<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DepartemenModel;

class DepartemenController extends Controller
{
    public function kelola_departemen()
    {
        $datadep = DepartemenModel::where('status_hapus', 0)
        ->select('id_departemen', 'nama_departemen')->orderBy('created_at','asc')->get();

        // Generate ID Bahan otomatis
        $lastDept = DepartemenModel::orderBy('created_at', 'desc')->first();
        $lastNumber = $lastDept ? (int) substr($lastDept->id_departemen, 4) : 0;
        $newNumber = $lastNumber + 1;
        $kodeOtomatis = 'DEP-' . str_pad($newNumber, 1, '0', STR_PAD_LEFT);
        return view('Kelola_Departemen.Departemen', compact('datadep', 'kodeOtomatis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_departemen' => 'required|unique:departemen,id_departemen',
            'nama_departemen' => 'required|unique:departemen,nama_departemen',
        ]);

        DepartemenModel::create([
            'id_departemen' => $request->id_departemen,
            'nama_departemen' => $request->nama_departemen,
        ]);

        return redirect('/keloladepartemen')->with('success', 'Data Departemen berhasil disimpan.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'id_departemen' => 'required|exists:departemen,id_departemen',
            'nama_departemen' => 'required',
        ]);

        $departemen = DepartemenModel::find($request->id_departemen);
        $departemen->update([
            'nama_departemen' => $request->nama_departemen,

        ]);

        return redirect('/keloladepartemen')->with('success', 'Data Departemen berhasil diupdate.');
    }

    public function delete($id_departemen)
    {
        $departemen = DepartemenModel::findOrFail($id_departemen);

        // Update status_hapus jadi 1 (soft delete manual)
        $departemen->update([
            'status_hapus' => 1
        ]);

        return redirect('/keloladepartemen')->with('success', 'Data Departemen berhasil dihapus (soft delete).');
    }
}
