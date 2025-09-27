<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ApiStaticKeyController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\OrganizationActivityController;
use App\Http\Controllers\OrganizationController;
use App\Http\Middleware\StaticApiKeyAuthenticationMiddleware;
use Illuminate\Support\Facades\Route;

Route::prefix('identity')->group(function () {
    Route::get('/', [ApiStaticKeyController::class, 'index'])->name('index');
    Route::post('/', [ApiStaticKeyController::class, 'store'])->name('store');
    Route::put('/{key}', [ApiStaticKeyController::class, 'update'])->name('update');
    Route::get('/{key}', [ApiStaticKeyController::class, 'show'])->name('show');
    Route::delete('/{key}', [ApiStaticKeyController::class, 'delete'])->name('delete');
});

Route::middleware(StaticApiKeyAuthenticationMiddleware::class)->group(function () {
    Route::prefix('activity')->name('activity.')->group(function () {
        Route::get('/', [ActivityController::class, 'index'])->name('index');
        Route::post('/', [ActivityController::class, 'store'])->name('store');
        Route::put('/{activity}', [ActivityController::class, 'update'])->name('update');
        Route::get('/{activity}', [ActivityController::class, 'show'])->name('show');
        Route::get('/{activity}/organizations', [ActivityController::class, 'getOrganizations'])->name('show-organizations');
        Route::delete('/{activity}', [ActivityController::class, 'delete'])->name('delete');
    });

    Route::prefix('organizations')->name('organizations.')->group(function () {
        Route::prefix('activities')->name('activities.')->group(function () {
            Route::get('/', [OrganizationActivityController::class, 'index'])->name('index');
            Route::post('/', [OrganizationActivityController::class, 'store'])->name('store');
            Route::put('/{activity}', [OrganizationActivityController::class, 'update'])->name('update');
            Route::get('/{activity}', [OrganizationActivityController::class, 'show'])->name('show');
            Route::delete('/{activity}', [OrganizationActivityController::class, 'delete'])->name('delete');
        });

        Route::get('/', [OrganizationController::class, 'index'])->name('index');
        Route::get('/search', [OrganizationController::class, 'search'])->name('search');
        Route::get('/search-location', [OrganizationController::class, 'searchByLocation'])->name('search-by-location.radius');
        Route::get('/search-bounds', [OrganizationController::class, 'searchByBounds'])->name('search-by-location.bounds');
        Route::post('/', [OrganizationController::class, 'store'])->name('store');
        Route::put('/{organization}', [OrganizationController::class, 'update'])->name('update');
        Route::get('/{organization}', [OrganizationController::class, 'show'])->name('show');
        Route::delete('/{organization}', [OrganizationController::class, 'delete'])->name('delete');
    });

    Route::prefix('buildings')->name('buildings.')->group(function () {
        Route::get('/', [BuildingController::class, 'index'])->name('index');
        Route::post('/', [BuildingController::class, 'store'])->name('store');
        Route::put('/{building}', [BuildingController::class, 'update'])->name('update');
        Route::get('/{building}', [BuildingController::class, 'show'])->name('show');
        Route::get('/{building}/organizations', [BuildingController::class, 'getAllOrganizations'])->name('show-organizations');
        Route::delete('/{building}', [BuildingController::class, 'delete'])->name('delete');
    });
});

