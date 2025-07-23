<?php

declare(strict_types=1);

namespace App\Http\Controllers\Management\Users;

use App\Actions\Users\DeleteUserAction;
use App\Actions\Users\GetUsersAction;
use App\Http\Controllers\Controller;
use App\Models\User;

final class UserController extends Controller
{
    public function index(GetUsersAction $action): \Inertia\Response
    {
        $users = $action->handle();

        return inertia('Users/Index', ['users' => $users]);
    }

    public function destroy(User $user, DeleteUserAction $action): \Illuminate\Http\RedirectResponse
    {
        $action->handle($user);

        return to_route('users.index')->with('status', 'Utilizador apagado com sucesso.');
    }
}
