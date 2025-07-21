<?php

namespace App\Http\Controllers;

use App\Actions\RolePermission\SyncPermissionsToRoleAction;
use App\Contracts\Permission\PermissionServiceInterface;
use App\Http\Requests\UpdateRolePermissionRequest;
use App\Models\Role;
use App\Services\Permission\PermissionService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RolePermissionController extends Controller
{
    public function __construct(private readonly PermissionServiceInterface $permissionService)
    {

    }

    public function edit(Role $role): \Inertia\Response
    {
        $permissions = $this->permissionService->getPermissions();

        return Inertia::render('RolePermission/Edit', compact('role', 'permissions'));
    }

    public function update(UpdateRolePermissionRequest $request, Role $role, SyncPermissionsToRoleAction $action): \Illuminate\Http\RedirectResponse
    {
        $action->handle($role, $request->validated('permissions'));
        return to_route('roles.index')->with('status', 'As permissões foram atualizadas com sucesso.');
    }
}
