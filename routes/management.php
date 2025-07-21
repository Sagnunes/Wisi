<?php

declare(strict_types=1);

use App\Http\Controllers\Permissions\PermissionController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\Roles\RoleController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->prefix('gestao-utilizadores')->group(function () {
    Route::prefix('permissoes')->group(function () {
        Route::get('/', [PermissionController::class, 'index'])->name('permissions.index');
        Route::post('/', [PermissionController::class, 'store'])->name('permissions.store');
        Route::patch('/{permission:uuid}', [PermissionController::class, 'update'])->name('permissions.update');
        Route::delete('/{permission:uuid}', [PermissionController::class, 'destroy'])->name('permissions.destroy');
        Route::get('/{permission:uuid}/editar', [PermissionController::class, 'edit'])->name('permissions.edit');

    });
    Route::prefix('perfis')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('roles.index');
        Route::post('/', [RoleController::class, 'store'])->name('roles.store');
        Route::patch('/{role:uuid}', [RoleController::class, 'update'])->name('roles.update');
        Route::delete('/{role:uuid}', [RoleController::class, 'destroy'])->name('roles.destroy');
        Route::get('/{role:uuid}/editar', [RoleController::class, 'edit'])->name('roles.edit');
    });

    Route::get('perfis/{role:uuid}/permissoes/editar', [RolePermissionController::class, 'edit'])->name('roles.permissions.edit');
});
