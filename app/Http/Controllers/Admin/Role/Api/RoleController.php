<?php

namespace App\Http\Controllers\Admin\Role\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Role\RoleRequest;
use App\Http\Services\Admin\Role\RoleService;
use App\Models\Role;
use App\Services\Response\ResponseService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;

class RoleController extends Controller
{
    private $services;
    public function __construct(RoleService $roleService)
    {
        $this->service = $roleService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function index(): JsonResponse
    {
        $this->authorize('view', Role::class);

        $roles = $this->service->getRoles();

        return ResponseService::sendJsonResponse(true, 200, [], [
            'items' => $roles,
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
     * @param RoleRequest $request
     * @return JsonResponse
     */
    public function store(RoleRequest $request)
    {
        $role = $this->service->save($request, new Role);

        return ResponseService::sendJsonResponse(true, 200, [], [
            'item' => $role
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Role $role
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function show(Role $role): JsonResponse
    {
        $this->authorize('view', Role::class);


        return ResponseService::sendJsonResponse(true, 200, [], [
            'item' => $role
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Role $role
     * @return void
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RoleRequest $request
     * @param Role $role
     * @return JsonResponse
     */
    public function update(RoleRequest $request, Role $role): JsonResponse
    {
        $this->authorize('update', Role::class);

        $role = $this->service->save($request, $role);

        return ResponseService::sendJsonResponse(true, 200, [], [
            'item' => $role
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Role $role
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function destroy(Role $role): JsonResponse
    {
        $this->authorize('delete', Role::class);

        $this->service->delete($role);

        return ResponseService::sendJsonResponse(true, 200, [], [
            'item' => $role
        ]);
    }
}
