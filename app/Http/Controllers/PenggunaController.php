<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PenggunaModel;
use App\Models\DepartemenModel;
use App\Models\RoleModel;

class PenggunaController extends Controller
{
    public function kelola_pengguna()
    {

        $datapengguna = PenggunaModel::select('id_pengguna','pengguna.id_departemen','departemen.nama_departemen','nama','pengguna.id_role','role.nama_role','username','email','password')
        ->join('departemen', 'departemen.id_departemen', '=', 'pengguna.id_departemen')
        ->join('role', 'role.id_role', '=', 'pengguna.id_role')
        ->where('pengguna.status_hapus', 0)
        ->get();


        $list_departemen = DepartemenModel::select('id_departemen', 'nama_departemen')->where('status_hapus', 0)->get();
        $list_role = RoleModel::select('id_role', 'nama_role')->where('status_hapus', 0)->get();
        
        // Generate ID Pengguna otomatis
        $lastPengguna = PenggunaModel::orderBy('created_at', 'desc')->first();
        $lastNumber = $lastPengguna ? (int) substr($lastPengguna->id_pengguna, 4) : 0;
        $newNumber = $lastNumber + 1;
        $kodeOtomatis = 'PGN-' . str_pad($newNumber, 1, '0', STR_PAD_LEFT);

        return view('Kelola_Pengguna.Pengguna', compact('list_departemen','list_role','datapengguna', 'kodeOtomatis'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'id_pengguna' => 'required|unique:pengguna,id_pengguna',
            'id_departemen' => 'nullable|exists:departemen,id_departemen',
            'id_role' => 'nullable|exists:role,id_role',
            'nama' => 'required|unique:pengguna,nama',
            'username' => 'required:pengguna,username',
            'email' => 'required|email|unique:pengguna,email',
            'password' => 'required|min:6',
            
        ]);

        PenggunaModel::create([
            'id_pengguna' => $request->id_pengguna,
            'id_departemen' => $request->id_departemen,
            'id_role' => $request->id_role,
            'nama' => $request->nama,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect('/kelolapengguna')->with('success', 'Data pengguna berhasil disimpan.');
    }


    public function update(Request $request)
    {
        $validated = $request->validate([
            'id_pengguna'         => 'required|exists:pengguna,id_pengguna',
            'username'            => 'required',
            'nama'       => 'required',
            'email'               => 'required|email',
            'password'            => 'nullable|min:6',
            'konfirmasi_password' => 'same:password',
            'id_role'         => 'required|exists:role,id_role',
            'id_departemen'       => 'required|exists:departemen,id_departemen',
        ], [
            'konfirmasi_password.same' => 'Password tidak cocok.',
        ]);

        $pengguna = PenggunaModel::findOrFail($request->id_pengguna);

        $pengguna->username = $request->username;
        $pengguna->nama = $request->nama;
        $pengguna->email = $request->email;
        $pengguna->id_role = $request->id_role;
        $pengguna->id_departemen = $request->id_departemen;

        if (!empty($request->password)) {
            $pengguna->password = bcrypt($request->password);
        }

        $pengguna->save();

        return redirect('/kelolapengguna')->with('success', 'Data pengguna berhasil diperbarui.');
    }


    public function delete($id_pengguna)
    {
        $pengguna = PenggunaModel::findOrFail($id_pengguna);

        // Update status_hapus jadi 1 (soft delete manual)
        $pengguna->update([
            'status_hapus' => 1
        ]);

        return redirect('/kelolapengguna')->with('success', 'Data Pengguna berhasil dihapus (soft delete).');
    }

}