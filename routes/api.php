<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Company\CompanyController;
use App\Http\Controllers\Permission\PermissionController;
use App\Http\Controllers\PingController;
use App\Http\Controllers\Role\RoleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::get('ping', [PingController::class, 'ping']);

Route::group([
    'middleware' => [],
], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('registration', [AuthController::class, 'registration']);
});

Route::group([
    'middleware' => ['api', 'auth'],
], function ($router) {
    Route::group([
        'prefix' => 'permission',
    ], function ($router) {
        Route::post('create', [PermissionController::class, 'create']);
        Route::post('generate', [PermissionController::class, 'generate']);
        Route::post('get_available', [PermissionController::class, 'getAvailable']);
        Route::post('get', [PermissionController::class, 'get']);
        Route::put('update', [PermissionController::class, 'update']);
        Route::delete('delete', [PermissionController::class, 'delete']);
    });
    Route::group([
        'prefix' => 'role',
    ], function ($router) {
        Route::post('create', [RoleController::class, 'create']);
        Route::post('get', [RoleController::class, 'get']);
        Route::put('update', [RoleController::class, 'update']);
        Route::delete('delete', [RoleController::class, 'delete']);
        Route::post('add_permission', [RoleController::class, 'addPermission']);
        Route::delete('delete_permission', [RoleController::class, 'deletePermission']);
    });
    Route::group([
        'prefix' => 'company',
    ], function ($router) {
        Route::post('create', [CompanyController::class, 'create']);
        Route::put('update', [CompanyController::class, 'update']);
        Route::post('get', [CompanyController::class, 'get']);
        Route::delete('delete', [CompanyController::class, 'delete']);
    });

});




