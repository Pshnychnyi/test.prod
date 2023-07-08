<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'alias',
        'title'
    ];

    public function perms()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function savePermissions($perms)
    {
        if(!empty($perms)) {
            $this->perms()->sync($perms);
        }else {
            $this->perms()->detach();
        }
    }

    public function hasPermission($alias, $require = false)
    {
        if(is_array($alias)) {
            foreach ($alias as $item) {
                $hasPermission = $this->hasPermission($item);
            }
            if($hasPermission && !$require) {
                return true;
            }elseif(!$hasPermission && $require){
                return false;
            }
        }else {
            foreach ($this->perms as $permission) {
                if($alias === $permission->alias) {
                    return true;
                }
            }
        }
        return $require;
    }
}
