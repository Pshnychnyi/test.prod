<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function view(User $user) {
        return $user->canDo(['SUPER_ADMINISTRATOR', 'USER_ACCESS']);
    }

    public function create(User $user) {
        return $user->canDo(['SUPER_ADMINISTRATOR', 'USER_CHANGE']);
    }

    public function update(User $user) {
        return $user->canDo(['SUPER_ADMINISTRATOR', 'USER_CHANGE']);
    }

    public function delete(User $user) {
        return $user->canDo(['SUPER_ADMINISTRATOR','USER_DELETE']);
    }
}
