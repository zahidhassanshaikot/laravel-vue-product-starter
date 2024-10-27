<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    use HasFactory;

    public function childs()
    {
        return $this->hasMany(Permission::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Permission::class, 'parent_id')->withDefault();
    }
}
