<?php

declare(strict_types=1);

namespace App\Http\Controllers\Management\Roles;

use App\Actions\RolePermission\SyncPermissionsToRoleAction;
use App\Contracts\Services\PermissionServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\RolePermission\UpdateRolePermissionRequest;
use App\Models\Role;
use Inertia\Inertia;

final class RolePermissionController extends Controller
{
    public function __construct(private readonly PermissionServiceInterface $permissionService) {}

    public function edit(Role $role): \Inertia\Response
    {
        $permissions = $this->permissionService->getPermissions();

        $role->load('permissions');

        return Inertia::render('RolePermission/Edit', ['role' => $role, 'permissions' => $permissions]);
    }

    public function update(UpdateRolePermissionRequest $request, Role $role, SyncPermissionsToRoleAction $action): \Illuminate\Http\RedirectResponse
    {
        $action->handle($role, $request->validated('selectedPermissions'));

        return to_route('roles.index')->with('status', 'As permissões foram atualizadas com sucesso.');
    }
}
