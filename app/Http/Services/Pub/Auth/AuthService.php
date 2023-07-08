<?php
namespace App\Http\Services\Pub\Auth;
use App\Jobs\ForgotEmailJob;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class AuthService
{

   /* public function signIn($request)
    {
        $remember = $request->has('remember');

        $credentials = $request->only(['email', 'password']);


        $result = auth()->guard()->attempt($credentials, $remember);

        return $result;

    }*/

    public function signInApi($request)
    {
        $credentials = $request->only(['email', 'password']);

        $token = auth()->attempt($credentials);

        return $token;

    }


    public function signUp($request, User $user)
    {
        $user->fill($request->only($user->getFillable()));

        $user->password = Hash::make($request->password);

        $user->save();

        $role = Role::where('alias', 'user')->first();

        $user->roles()->sync($role->id);

        return $user;
    }

    /*public function signUpWithSocial($request, $user, $provider_id)
    {
        $user->name = $request->getName();
        $user->email = $request->getEmail();
        $user->$provider_id = $request->id;

        $user->save();

        $role = Role::where('alias', 'user')->first();

        $user->roles()->sync($role->id);

        return $user;
    }


    public function handleCallback($provider)
    {

        try {
            $request = clone Socialite::driver($provider)->user();

            $provider_id = $provider . '_id';

            $user = User::where($provider_id, $request->id)->first();
            if($user) {
                auth()->guard()->login($user);
            }else {

                $this->signUpWithSocial($request, new User(), $provider_id);
            }
            return true;

        }catch (\Exception $e) {
            dd($e->getMessage());
        }

    }*/
    public function forgot($request)
    {
        $user = User::where('email', $request['email'])->first();

        $password = uniqid();

        $user->password = Hash::make($password);

        $user->save();

        dispatch(new ForgotEmailJob($user, $password));


    }
}
