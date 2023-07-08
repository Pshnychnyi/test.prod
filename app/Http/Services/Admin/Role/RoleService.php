<?php

namespace App\Http\Services\Admin\Role;

use App\Models\Role;

class RoleService
{

    public function getRoles()
    {
        $roles = Role::get();
        return $roles;
    }

    public function save($request, Role $role)
    {
        $role->fill($request->only($role->getFillable()));

        $role->save();

        return $role;
    }

    public function delete(Role $role)
    {
        $role->delete();

    }
}
