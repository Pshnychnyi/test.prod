<?php

namespace App\Http\Controllers\Pub\Auth\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pub\Auth\Api\ForgotRequest;
use App\Http\Requests\Pub\Auth\Api\LoginRequest;
use App\Http\Requests\Pub\Auth\Api\RegistrationRequest;
use App\Http\Services\Pub\Auth\AuthService;
use App\Mail\ForgotMail;
use App\Models\User;
use App\Services\Response\ResponseService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    private AuthService $service;

    public function __construct(AuthService $authService)
    {
        $this->middleware('guest')->except(['logout', 'me', 'refresh']);


        $this->service = $authService;
    }

    public function signUp(RegistrationRequest $request)
    {

        $user = $this->service->signUp($request, new User());

        return ResponseService::sendJsonResponse(true, 200, [], [
            'user' => $user
        ]);
    }
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function signIn(LoginRequest $request)
    {
        $token = $this->service->signInApi($request);

        return ResponseService::sendJsonResponse(true, 200, [], [
            'token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => auth()->guard()->factory()->getTTL() * 60
        ]);


    }

    public function forgot(ForgotRequest $request)
    {
        $this->service->forgot($request);

        return ResponseService::success();
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return ResponseService::sendJsonResponse(true, 200, [], [
            'user' => auth()->user()
        ]);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return ResponseService::sendJsonResponse(true, 200, [], [
            'message' => __('auth.logout')
        ]);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return ResponseService::sendJsonResponse(true, 200, [], [
            'token' => auth()->refresh(),
            'token_type' => 'Bearer',
            'expires_in' => auth()->guard('api')->factory()->getTTL() * 60
        ]);
    }

}
