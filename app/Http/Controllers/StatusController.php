<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StatusModel; 

class StatusController extends Controller
{
    public function kelola_status()
    {
        $datastatus = StatusModel::where('status_hapus', 0)
        ->select('id_status', 'nama_status', 'urutan')
        ->orderByRaw('CAST(SUBSTRING(id_status, 4) AS UNSIGNED) ASC')->get();

        // Generate ID Bahan otomatis
        $laststatus = StatusModel::selectRaw("MAX(CAST(SUBSTRING(id_status, 4) AS UNSIGNED)) AS max_id")->first();
        $lastNumber = $laststatus->max_id ?? 0;
        $newNumber = $lastNumber + 1;
        $kodeOtomatis = 'ST-' . $newNumber;


    	return view('kelola_status.status', compact('datastatus', 'kodeOtomatis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_status' => 'required|unique:statuses,id_status',
            'nama_status' => 'required',
            'urutan' => 'required|integer',
        ]);

        StatusModel::create([
            'id_status' => $request->id_status,
            'nama_status' => $request->nama_status,
            'urutan' => $request->urutan,
            'status_hapus' => 0
        ]);

        return redirect()->route('status.kelola')->with('success', 'Status berhasil ditambahkan');
    }

    public function update(Request $request)
    {
        $request->validate([
            'id_status' => 'required',
            'nama_status' => 'required',
            'urutan' => 'nullable|integer',
        ]);

        $status = StatusModel::findOrFail($request->id_status);
        $status->update([
            'nama_status' => $request->nama_status,
            'urutan' => $request->urutan,
        ]);

        return redirect()->route('status.kelola')->with('success', 'Data berhasil diperbarui!');
    }

    
    public function delete($id_status)
    {
        $status = StatusModel::findOrFail($id_status);

        // Update status_hapus jadi 1 (soft delete manual)
        $status->update([
            'status_hapus' => 1
        ]);

        return redirect()->route('status.kelola')->with('success', 'Data status berhasil dihapus.');
    }
}
