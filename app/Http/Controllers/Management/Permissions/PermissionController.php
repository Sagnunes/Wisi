<?php

declare(strict_types=1);

namespace App\Http\Controllers\Management\Permissions;

use App\Actions\Permission\CreatePermission;
use App\Actions\Permission\DeletePermission;
use App\Actions\Permission\GetPermissions;
use App\Actions\Permission\UpdatePermission;
use App\DTOs\PermissionDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Permission\StorePermissionRequest;
use App\Http\Requests\Permission\UpdatePermissionRequest;
use App\Models\Permission;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;

final class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GetPermissions $action): \Inertia\Response
    {
        return Inertia::render('Permissions/Index', ['permissions' => $action->handle()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePermissionRequest $request, CreatePermission $action): RedirectResponse
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
    public function update(UpdatePermissionRequest $request, Permission $permission, UpdatePermission $action): RedirectResponse
    {
        $action->handle($permission, PermissionDTO::fromRequest($request->validated()));

        return to_route('permissions.edit', $permission);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission, DeletePermission $action): RedirectResponse
    {
        $action->handle($permission);

        return redirect()->back()->with('status', 'Permissão eliminada com sucesso.');
    }
}
