<?php

namespace App\Http\Controllers\Admin\User\Api;

use App\Http\Controllers\Admin\Base;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\UserRequest;
use App\Http\Services\Admin\User\UserService;
use App\Models\User;
use App\Services\Response\ResponseService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $service;
    public function __construct(UserService $userService)
    {
        $this->service = $userService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, User $user): \Illuminate\Http\JsonResponse
    {

        $this->authorize('view', User::class);

        $search = $request->input('search');


        $users = $this->service->getUsers($request, $user);


        return ResponseService::sendJsonResponse(true, 200, [], [
            'items' => $users,
            'search' => $search,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserRequest $request): \Illuminate\Http\JsonResponse
    {   $this->authorize('store', User::class);

        $user = $this->service->save($request, new User());

        return ResponseService::sendJsonResponse(true, 200, [], [
            'item' => $user,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     * @throws AuthorizationException
     */
    public function show(User $user): \Illuminate\Http\JsonResponse
    {
        $this->authorize('view', User::class);

        return ResponseService::sendJsonResponse(true, 200, [], [
            'item' => $user,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return Application|Factory|View
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UserRequest $request, User $user)
    {

        $this->authorize('view', User::class);

        $user = $this->service->save($request, $user);

        return ResponseService::sendJsonResponse(true, 200, [], [
            'item' => $user,
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', User::class);

        $user = $this->service->delete($user);

        return ResponseService::sendJsonResponse(true, 200, [], [
            'item' => $user,
        ]);
    }
}
