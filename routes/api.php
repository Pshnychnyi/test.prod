<?php

use App\Http\Controllers\Admin\Permission\Api\PermissionController;
use App\Http\Controllers\Admin\Role\Api\RoleController;
use App\Http\Controllers\Admin\User\Api\UserController;
use App\Http\Controllers\Pub\Auth\Api\AuthController;
use App\Http\Controllers\Pub\Cars\Api\CarsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::group(['middleware' => [],'prefix' => 'auth'], function ($router) {

    Route::post('/signUp', [AuthController::class, 'signUp']);
    Route::post('/signIn', [AuthController::class, 'signIn']);

    Route::post('forgot', [AuthController::class, 'forgot']);

    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);

});



Route::group(['middleware' => 'auth:api'], function () {

    Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
        Route::resource('/roles', RoleController::class);
        Route::resource('/permissions', PermissionController::class);
        Route::resource('/users', UserController::class);
    });

    Route::resource('cars', CarsController::class);
    Route::get('cars/export', [CarsController::class, 'export'])->name('cars.export');
    Route::get('cars/autocomplete/{make}', [CarsController::class, 'autocomplete']);

});

