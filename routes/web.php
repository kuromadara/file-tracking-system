<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RolePermissionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::middleware(['auth'/* , 'can:manage_roles_and_permissions' */])->group(function () {
    Route::get('/roles-permissions', [RolePermissionController::class, 'index'])->name('roles-permissions.index');
    Route::post('/roles', [RolePermissionController::class, 'createRole'])->name('roles.create');
    Route::post('/permissions', [RolePermissionController::class, 'createPermission'])->name('permissions.create');
    Route::post('/roles/assign', [RolePermissionController::class, 'assignRole'])->name('roles.assign');
    Route::post('/permissions/assign', [RolePermissionController::class, 'assignPermission'])->name('permissions.assign');
    Route::get('/users-with-roles', [RolePermissionController::class, 'getUsersWithRoles'])->name('users.with.roles');
    Route::post('/roles/remove', [RolePermissionController::class, 'removeRole'])->name('roles.remove');
    Route::get('/roles/permissions', [RolePermissionController::class, 'getRolePermissions'])->name('roles.permissions');
});
