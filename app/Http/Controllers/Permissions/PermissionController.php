<?php

declare(strict_types=1);

namespace App\Http\Controllers\Permissions;

use App\Actions\Permission\CreatePermissionAction;
use App\Actions\Permission\DeletePermissionAction;
use App\Actions\Permission\GetPermissionsAction;
use App\Actions\Permission\UpdatePermissionAction;
use App\DTOs\Permission\PermissionDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use App\Models\Permission;
use Inertia\Inertia;

final class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GetPermissionsAction $action): \Inertia\Response
    {
        $permissions = $action->handle();

        return Inertia::render('Permissions/Index', ['permissions' => $permissions]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePermissionRequest $request, CreatePermissionAction $action): \Illuminate\Http\RedirectResponse
    {
        $createdPermission = $action->handle(PermissionDTO::fromRequest($request->validated()));

        return to_route('permissions.index')->with(['status' => 'Permissão criada com sucesso.', 'data' => $createdPermission]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission): \Inertia\Response
    {
        return Inertia::render('Permissions/Edit', ['permission' => $permission]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePermissionRequest $request, Permission $permission, UpdatePermissionAction $action): \Illuminate\Http\RedirectResponse
    {
        $action->handle($permission, PermissionDTO::fromRequest($request->validated(), $permission->uuid));

        return to_route('permissions.edit', $permission);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission, DeletePermissionAction $action): \Illuminate\Http\RedirectResponse
    {
        $action->handle($permission);

        return redirect()->back()->with('status', 'Permissão eliminada com sucesso.');
    }
}
