<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\API\PersonController;
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

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
//    Route::post('register', 'register');
    Route::post('logout', 'logout');
});

Route::get('/probably', function(){
    dd('probably');
});

//Route::post('/login', [LoginController::class, 'authenticate']);
//Route::middleware('auth:api')->get('/users/list', [UserController::class, 'getUsersList']);

Route::controller(UserController::class)->group(function () {
    Route::get('/users/list', 'getUsersList');
    Route::post('/user/create', 'createUser');
    Route::get('/user/get/{id}', 'getUser');
    Route::delete('/user/delete/{id}', 'deleteUser');
    Route::put('/user/update', 'updateUser');
});

Route::get('/role/list', function() {
    return config('enums.roles');
});

Route::controller(PersonController::class)->group(function () {
    Route::post('/person/create', 'createPerson');
});
