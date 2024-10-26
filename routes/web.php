<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\FixedAssetController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\FileController;
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

Route::middleware(['auth'/* , 'can:manage_departments' */])->group(function () {
    Route::get('/departments', [DepartmentController::class, 'index'])->name('departments.index');
    Route::get('/departments/data', [DepartmentController::class, 'getDepartments'])->name('departments.data');
    Route::get('/departments/create', [DepartmentController::class, 'create'])->name('departments.create');
    Route::post('/departments', [DepartmentController::class, 'store'])->name('departments.store');
    Route::get('/departments/{department}', [DepartmentController::class, 'show'])->name('departments.show');
    Route::get('/departments/{department}/edit', [DepartmentController::class, 'edit'])->name('departments.edit');
    Route::put('/departments/{department}', [DepartmentController::class, 'update'])->name('departments.update');
    Route::delete('/departments/{department}', [DepartmentController::class, 'destroy'])->name('departments.destroy');
});

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

Route::middleware(['auth'/* , 'can:manage_sections' */])->group(function () {
    Route::get('/sections', [SectionController::class, 'index'])->name('sections.index');
    Route::get('/sections/data', [SectionController::class, 'getSections'])->name('sections.data');
    Route::get('/sections/create', [SectionController::class, 'create'])->name('sections.create');
    Route::post('/sections', [SectionController::class, 'store'])->name('sections.store');
    Route::get('/sections/{section}', [SectionController::class, 'show'])->name('sections.show');
    Route::get('/sections/{section}/edit', [SectionController::class, 'edit'])->name('sections.edit');
    Route::put('/sections/{section}', [SectionController::class, 'update'])->name('sections.update');
    Route::delete('/sections/{section}', [SectionController::class, 'destroy'])->name('sections.destroy');
});

Route::middleware(['auth'/* , 'can:manage_locations' */])->group(function () {
    Route::get('/locations', [LocationController::class, 'index'])->name('locations.index');
    Route::get('/locations/data', [LocationController::class, 'getLocations'])->name('locations.data');
    Route::get('/locations/create', [LocationController::class, 'create'])->name('locations.create');
    Route::post('/locations', [LocationController::class, 'store'])->name('locations.store');
    Route::get('/locations/{location}', [LocationController::class, 'show'])->name('locations.show');
    Route::get('/locations/{location}/edit', [LocationController::class, 'edit'])->name('locations.edit');
    Route::put('/locations/{location}', [LocationController::class, 'update'])->name('locations.update');
    Route::delete('/locations/{location}', [LocationController::class, 'destroy'])->name('locations.destroy');
});

Route::middleware(['auth'/* , 'can:manage_fixed_assets' */])->group(function () {
    Route::get('/fixed-assets', [FixedAssetController::class, 'index'])->name('fixed-assets.index');
    Route::get('/fixed-assets/data', [FixedAssetController::class, 'getFixedAssets'])->name('fixed-assets.data');
    Route::get('/fixed-assets/create', [FixedAssetController::class, 'create'])->name('fixed-assets.create');
    Route::post('/fixed-assets', [FixedAssetController::class, 'store'])->name('fixed-assets.store');
    Route::get('/fixed-assets/{fixedAsset}', [FixedAssetController::class, 'show'])->name('fixed-assets.show');
    Route::get('/fixed-assets/{fixedAsset}/edit', [FixedAssetController::class, 'edit'])->name('fixed-assets.edit');
    Route::put('/fixed-assets/{fixedAsset}', [FixedAssetController::class, 'update'])->name('fixed-assets.update');
    Route::delete('/fixed-assets/{fixedAsset}', [FixedAssetController::class, 'destroy'])->name('fixed-assets.destroy');
    Route::get('/fixed-assets/{fixedAsset}/files/create', [FileController::class, 'create'])->name('files.create');
    Route::post('/fixed-assets/{fixedAsset}/files', [FileController::class, 'store'])->name('files.store');
    Route::get('/files/{file}/edit', [FileController::class, 'edit'])->name('files.edit');
    Route::put('/files/{file}', [FileController::class, 'update'])->name('files.update');
    Route::delete('/files/{file}', [FileController::class, 'destroy'])->name('files.destroy');
    Route::get('/files/{file}/movements', [FileController::class, 'showMovements'])->name('files.movements');
    Route::put('/files/{file}/move', [FileController::class, 'move'])->name('files.move');
});
