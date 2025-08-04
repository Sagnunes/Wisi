<?php

declare(strict_types=1);

namespace App\Http\Controllers\Management\Users;

use App\Actions\Role\GetRoles;
use App\Actions\UserRole\UpdateUserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRole\UpdateUserRoleRequest;
use App\Models\User;
use Inertia\Inertia;

final class UserRoleController extends Controller
{
    public function edit(User $user, GetRoles $action): \Inertia\Response
    {
        $roles = $action->handle();

        $user->load('roles');

        return Inertia::render('UserRoles/Edit', ['user' => $user, 'roles' => $roles]);
    }

    public function update(User $user, UpdateUserRoleRequest $request, UpdateUserRole $action): \Illuminate\Http\RedirectResponse
    {
        $action->handle($user, $request->validated('selectedRoles'));

        return to_route('users.index')->with('status', 'Os perfis do utilizador foram atualizados com sucesso.');
    }
}
