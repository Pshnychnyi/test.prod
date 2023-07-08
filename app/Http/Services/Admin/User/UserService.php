<?php

namespace App\Http\Services\Admin\User;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserService
{

    public function getUsers(Request $request, User $user, $status = false)
    {
        $userBuilder = $user->getUserBySearch($request)->with('roles');

        if($status) {
            $userBuilder->where('status', (int) $status);
        }

        $users = $userBuilder->get();

        return $users;
    }

    public function save($request, User $user)
    {
        $user->fill($request->only($user->getFillable()));

        if($user->password) {
            $user->password = Hash::make($request->password);
        }else {
            unset($user->password);
        }


        $user->save();

        $role = $request->role_id;

        $user->roles()->sync($role);

        return $user;
    }

    public function delete(User $user)
    {
        $user->status = '0';
        $user->update();

        return $user;
    }
}
