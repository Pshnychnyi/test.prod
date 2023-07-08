<?php

namespace App\Policies;

use App\Models\User;

class CarPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function view(User $user) {
        return $user->canDo(['SUPER_ADMINISTRATOR', 'CAR_ACCESS']);
    }

    public function create(User $user) {
        return $user->canDo(['SUPER_ADMINISTRATOR', 'CAR_CHANGE']);
    }

    public function update(User $user) {
        return $user->canDo(['SUPER_ADMINISTRATOR', 'CAR_CHANGE']);
    }

    public function delete(User $user) {
        return $user->canDo(['SUPER_ADMINISTRATOR','CAR_DELETE']);
    }
}
