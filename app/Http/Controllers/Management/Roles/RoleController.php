<?php

declare(strict_types=1);

namespace App\Http\Controllers\Management\Roles;

use App\Actions\Role\CreateRoleAction;
use App\Actions\Role\DeleteRoleAction;
use App\Actions\Role\GetRolesAction;
use App\Actions\Role\UpdateRoleAction;
use App\DTOs\RoleDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Roles\StoreRoleRequest;
use App\Http\Requests\Roles\UpdateRoleRequest;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

final class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GetRolesAction $action): Response
    {
        return Inertia::render('Roles/Index', [
            'roles' => $action->handle(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request, CreateRoleAction $action): RedirectResponse
    {
        $createdRole = $action->handle(RoleDTO::fromRequest($request->validated()));

        return to_route('roles.index')->with(['status' => 'Perfil criado com sucesso', 'data' => $createdRole]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role): Response
    {
        return Inertia::render('Roles/Edit', ['role' => $role]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role, UpdateRoleAction $action): RedirectResponse
    {
        $action->handle($role, RoleDTO::fromRequest($request->validated()));

        return to_route('roles.edit', $role);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role, DeleteRoleAction $action)
    {
        $action->handle($role);

        return redirect()->back()->with('status', 'Perfil eliminado com sucesso');
    }
}
