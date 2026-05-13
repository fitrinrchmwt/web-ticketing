<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermissionModel extends Model
{
    protected $table = 'permission';
    protected $primaryKey = 'id_permission';
    public $incrementing = false;
    public $keyType = 'string';
    public $timestamps = false;
    protected $fillable = [
        'id_permission',
        'nama_permission',
    ];

    // Relasi many-to-many dengan RoleModel melalui tabel pivot role_permission
    public function roles()
    {
        return $this->belongsToMany(RoleModel::class, 'role_permission', 'id_permission', 'id_role');
    }
    
}
