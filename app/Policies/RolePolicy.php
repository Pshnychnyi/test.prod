<?php

namespace App\Policies;

use App\Models\User;

class RolePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function view(User $user) {
        return $user->canDo(['SUPER_ADMINISTRATOR', 'ROLE_ACCESS']);
    }

    public function create(User $user) {
        return $user->canDo(['SUPER_ADMINISTRATOR', 'ROLE_CHANGE']);
    }

    public function update(User $user) {
        return $user->canDo(['SUPER_ADMINISTRATOR', 'ROLE_CHANGE']);
    }

    public function delete(User $user) {
        return $user->canDo(['SUPER_ADMINISTRATOR','ROLE_CHANGE']);
    }
}
