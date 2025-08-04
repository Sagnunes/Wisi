<?php

declare(strict_types=1);

namespace App\Http\Controllers\Management\Users;

use App\Actions\UserStatus\UpdateUserStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserStatus\UpdateUserStatusRequest;
use App\Models\User;

final class UserStatusController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(User $user, UpdateUserStatusRequest $request, UpdateUserStatus $action): \Illuminate\Http\RedirectResponse
    {
        $action->handle($user, $request->validated('updatedStatus'));

        return to_route('users.index')->with('status', 'O utilizador foi atualizado com sucesso.');
    }
}
