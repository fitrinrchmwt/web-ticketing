<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleModel extends Model
{
    use HasFactory;

    protected $table = 'role';
    protected $primaryKey = 'id_role';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'id_role',
        'nama_role',
        'status_hapus',
    ];

    // Relasi many-to-many dengan permissionModel melalui tabel pivot role_permission
    public function permission()
    {
        return $this->belongsToMany(PermissionModel::class, 'role_permission', 'id_role', 'id_permission');
    }

    
}
