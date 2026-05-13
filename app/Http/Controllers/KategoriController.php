<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriModel;

class KategoriController extends Controller
{
    public function kelola_kategori()
    {
        $datakategori = KategoriModel::where('status_hapus', 0)
        ->select('id_kategori', 'nama_kategori')->get();

        // Generate ID Bahan otomatis
        $lastkategori = KategoriModel::orderBy('id_kategori', 'desc')->first();
        $lastNumber = $lastkategori ? (int) substr($lastkategori->id_kategori, 4) : 0;
        $newNumber = $lastNumber + 1;
        $kodeOtomatis = 'KTG-' . str_pad($newNumber, 1, '0', STR_PAD_LEFT);

    	return view('Kelola_Kategori.Kelola_Kategori', compact('datakategori', 'kodeOtomatis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_kategori' => 'required|unique:kategori,id_kategori',
            'nama_kategori' => 'required|unique:kategori,nama_kategori',
        ]);

        KategoriModel::create([
            'id_kategori' => $request->id_kategori,
            'nama_kategori' => $request->nama_kategori,
        ]);

        return redirect('/kelolakategori')->with('success', 'Kategori berhasil disimpan.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'nama_kategori' => 'required',
        ]);

        $kategori = KategoriModel::find($request->id_kategori);
        $kategori->update([
            'nama_kategori' => $request->nama_kategori,

        ]);

        return redirect('/kelolakategori')->with('success', 'Data Kategori berhasil diupdate.');
    }

    public function delete($id_kategori)
    {
        $kategori = KategoriModel::findOrFail($id_kategori);

        // Update status_hapus jadi 1 (soft delete manual)
        $kategori->update([
            'status_hapus' => 1
        ]);

        return redirect('/kelolakategori')->with('success', 'Data Kategori berhasil dihapus (soft delete).');
    }
}