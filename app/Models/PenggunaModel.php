<?php

namespace App\Models;


use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ResetPasswordCustom;

class PenggunaModel extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $table = 'pengguna';
    protected $primaryKey = 'id_pengguna';
    public $incrementing = false;
    public $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_pengguna',
        'id_departemen',
        'id_role',
        'nama',
        'username',
        'email',
        'password',
        'status_hapus'
    ];

    // Relasi many-to-one dengan RoleModel
    public function role()
    {
        return $this->belongsTo(RoleModel::class, 'id_role', 'id_role');
    }

    public function departemen()
    {
        return $this->belongsTo(DepartemenModel::class, 'id_departemen', 'id_departemen');
    }

    // Cek apakah user punya permission tertentu
    public function hasPermission($perm)
    {
        // jika user tidak punya role, kembalikan false
        if (!$this->role)
            return false;

        // cek apakah role memiliki permission tersebut
        return $this->role->permission->contains('nama_permission', $perm);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordCustom($token));
    }
}
