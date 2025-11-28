<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    use HasFactory;

    protected $table = 'permissions';

    protected $fillable = [
        'name',
        'display_name',
        'group_id',
        'guard_name',
    ];

    /**
     * Relationship: Permission belongs to a PermissionGroup
     */
    public function group()
    {
        return $this->belongsTo(PermissionGroup::class, 'group_id');
    }
}
