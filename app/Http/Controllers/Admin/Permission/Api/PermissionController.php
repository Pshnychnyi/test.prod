<?php

namespace App\Http\Controllers\Admin\Permission\Api;

use App\Http\Controllers\Controller;
use App\Http\Services\Admin\Permissions\PermissionService;
use App\Models\Permission;
use App\Models\Role;
use App\Services\Response\ResponseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    private $service;

    public function __construct(PermissionService $permissionService)
    {
        $this->service = $permissionService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $this->authorize('view', Role::class);
        $permissions = $this->service->getPermissions();
        $roles = Role::all();

        return ResponseService::sendJsonResponse(true, 200, [], [
            'permissions' => $permissions,
            'roles' => $roles
        ]);
    }

    public function store(Request $request)
    {

        $this->authorize('update', Role::class);
        $this->service->save($request);

        return ResponseService::success();
    }
}
