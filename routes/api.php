<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AccountController;
use App\Http\Controllers\Api\PersonController;
use App\Http\Controllers\Api\Additionally\PrivacyPolicyController;
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

Route::controller(AccountController::class)->group(function () {
    Route::get('/account/list/person/{idPerson}', 'getAccountList');
    Route::post('/account/create', 'createAccount');
    Route::get('/account/get/{id}', 'getAccount');
    Route::delete('/account/delete/{id}', 'deleteAccount');
    Route::put('/account/update', 'updateAccount');
});

Route::get('/role/list', function() {
    return config('enums.roles');
});

Route::controller(PersonController::class)->group(function () {
    Route::post('/person/create', 'createPerson');
    Route::get('/person/list', 'getPersonsList');
    Route::get('/person/get/{id}', 'getPerson');
    Route::put('/person/update', 'updatePerson');
    Route::delete('/person/delete/{id}', 'deletePerson');
});

Route::controller(PrivacyPolicyController::class)->group(function() {
    Route::get('/privacy-policy', 'getPrivacyPolicy');
    Route::post('/privacy-policy/save', 'savePrivacyPolicy');
});
