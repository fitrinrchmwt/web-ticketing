<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RolePermissionModel extends Model
{
    protected $table = 'role_permission';
    public $timestamps = false;
    protected $fillable = [
        'id_role',
        'id_permission',
    ];

    // Relasi many-to-many dengan RoleModel melalui tabel pivot role_permission
    public function roles()
    {
        return $this->belongsToMany(RoleModel::class, 'role_permission', 'id_permission', 'id_role');
    }
    // Relasi many-to-many dengan permissionModel melalui tabel pivot role_permission
    public function permission()
    {
        return $this->belongsToMany(PermissionModel::class, 'role_permission', 'id_role', 'id_permission');
    }
}
