<?php

namespace App\Http\Services\Admin\Permissions;

use App\Models\Permission;
use App\Models\Role;

class PermissionService
{

    public function getPermissions()
    {
        return Permission::all();
    }

    public function save($request)
    {
        $data = $request->except('_token');

        $roles = Role::all();

        foreach ($roles as $role) {

            if(isset($data[$role->id])) {
                $role->savePermissions($data[$role->id]);
            }else {
                $role->savePermissions([]);
            }
        }
        return true;
    }
}
