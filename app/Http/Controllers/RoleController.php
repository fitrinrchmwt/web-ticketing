<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoleModel;
use App\Models\PermissionModel;

class RoleController extends Controller
{
    // Menampilkan halaman Role
    public function kelola_role()
    {
        $datarole = RoleModel::with('permission')->where('status_hapus', 0)
            ->select('id_role', 'nama_role')
            ->get();

        // Ambil semua permission
        $permissions = PermissionModel::all();

        // Generate ID otomatis
        $lastRole = RoleModel::orderBy('created_at', 'desc')->first();
        $lastNumber = $lastRole ? (int) substr($lastRole->id_role, 3) : 0; // RL-1 dst
        $newNumber = $lastNumber + 1;
        $kodeOtomatis = 'RL-' . str_pad($newNumber, 2, '0', STR_PAD_LEFT);

        return view('Kelola_Role.Role', compact('datarole', 'kodeOtomatis', 'permissions'));
    }


    // Menyimpan data Role baru
    public function store(Request $request)
    {
        $request->validate([
            'id_role' => 'required|string|unique:role,id_role',
            'nama_role' => 'required|string|max:100',
            'permissions' => 'array', // bisa kosong
        ]);

        $role = RoleModel::create([
            'id_role' => $request->id_role,
            'nama_role' => $request->nama_role,
            'status_hapus' => 0,
        ]);

        // Simpan permission ke tabel pivot
        if ($request->has('permissions')) {
            $role->permission()->sync($request->permissions);
        }

        return redirect()->back()->with('success', 'Role baru berhasil ditambahkan!');
    }

    // Mengupdate data Role
     public function update(Request $request)
    {
        $request->validate([
            'id_role' => 'required|exists:role,id_role',
            'nama_role' => 'required|string|max:100',
            'permissions' => 'array',
        ]);

        $role = RoleModel::find($request->id_role);
        $role->update([
            'nama_role' => $request->nama_role,
        ]);

        // Update role_permission
        $role->permission()->sync($request->permissions ?? []);

        return redirect()->back()->with('success', 'Role berhasil diperbarui!');
    }

    // Menghapus data Role
    public function delete($id_role)
    {
        $role = RoleModel::findOrFail($id_role);

        // Update status_hapus jadi 1 (soft delete manual)
        $role->update([
            'status_hapus' => 1
        ]);

        return redirect('/kelolarole')->with('success', 'Data Role berhasil dihapus (soft delete).');
    }
}
