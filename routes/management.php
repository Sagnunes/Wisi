<?php

declare(strict_types=1);

use App\Http\Controllers\Management\Permissions\PermissionController;
use App\Http\Controllers\Management\Roles\RoleController;
use App\Http\Controllers\Management\Roles\RolePermissionController;
use App\Http\Controllers\Management\Users\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->prefix('gestao-utilizadores')->group(function () {
    Route::prefix('permissoes')->group(function () {
        Route::get('/', [PermissionController::class, 'index'])->name('permissions.index');
        Route::post('/', [PermissionController::class, 'store'])->name('permissions.store');
        Route::patch('/{permission:id}', [PermissionController::class, 'update'])->name('permissions.update');
        Route::delete('/{permission:id}', [PermissionController::class, 'destroy'])->name('permissions.destroy');
        Route::get('/{permission:slug}/editar', [PermissionController::class, 'edit'])->name('permissions.edit');

    });
    Route::prefix('perfis')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('roles.index');
        Route::post('/', [RoleController::class, 'store'])->name('roles.store');
        Route::patch('/{role:id}', [RoleController::class, 'update'])->name('roles.update');
        Route::delete('/{role:id}', [RoleController::class, 'destroy'])->name('roles.destroy');
        Route::get('/{role:slug}/editar', [RoleController::class, 'edit'])->name('roles.edit');
        Route::get('/{role:slug}/permissoes/editar', [RolePermissionController::class, 'edit'])->name('roles.permissions.edit');
        Route::patch('/{role:id}/permissoes/', [RolePermissionController::class, 'update'])->name('roles.permissions.update');
    });

    Route::prefix('utilizadores')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index');
    });
});
