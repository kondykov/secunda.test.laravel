<?php

use App\Http\Controllers\ActivityCategoryController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\OrganizationActivityController;
use App\Http\Controllers\OrganizationController;
use Illuminate\Support\Facades\Route;

Route::prefix('activity')->name('activity.')->group(function () {
    Route::prefix('category')->name('category.')->group(function () {
        Route::get('/', [ActivityCategoryController::class, 'index'])->name('index');
        Route::post('/', [ActivityCategoryController::class, 'store'])->name('store');
        Route::put('/', [ActivityCategoryController::class, 'update'])->name('update');
        Route::get('/{category}', [ActivityCategoryController::class, 'show'])->name('show');
        Route::delete('/{category}', [ActivityCategoryController::class, 'delete'])->name('delete');
    });

    Route::get('/', [ActivityController::class, 'index'])->name('index');
    Route::post('/', [ActivityController::class, 'store'])->name('store');
    Route::put('/', [ActivityController::class, 'update'])->name('update');
    Route::get('/{activity}', [ActivityController::class, 'show'])->name('show');
    Route::delete('/{activity}', [ActivityController::class, 'delete'])->name('delete');
});

Route::prefix('organizations')->name('organizations.')->group(function () {
    Route::prefix('activities')->name('activities.')->group(function () {
        Route::get('/', [OrganizationActivityController::class, 'index'])->name('index');
        Route::post('/', [OrganizationActivityController::class, 'store'])->name('store');
        Route::put('/', [OrganizationActivityController::class, 'update'])->name('update');
        Route::get('/{activity}', [OrganizationActivityController::class, 'show'])->name('show');
        Route::delete('/{activity}', [OrganizationActivityController::class, 'delete'])->name('delete');
    });

    Route::get('/', [OrganizationController::class, 'index'])->name('index');
    Route::post('/', [OrganizationController::class, 'store'])->name('store');
    Route::put('/', [OrganizationController::class, 'update'])->name('update');
    Route::get('/{organization}', [OrganizationController::class, 'show'])->name('show');
    Route::delete('/{organization}', [OrganizationController::class, 'delete'])->name('delete');
});

Route::prefix('buildings')->name('buildings.')->group(function () {
    Route::get('/', [BuildingController::class, 'index'])->name('index');
    Route::post('/', [BuildingController::class, 'store'])->name('store');
    Route::put('/', [BuildingController::class, 'update'])->name('update');
    Route::get('/{building}', [BuildingController::class, 'show'])->name('show');
    Route::get('/{building}/organizations', [BuildingController::class, 'getAllOrganizations'])->name('show-organizations');
    Route::delete('/{building}', [BuildingController::class, 'delete'])->name('delete');
});
