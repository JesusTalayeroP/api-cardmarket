<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('users')->group(function () {
	Route::post('/signup',[UserController::class, 'signup_user']);
	Route::post('/signup_admin',[UserController::class, 'signup_admin']);
	Route::post('/login',[UserController::class, 'login_user']);
	Route::post('/forget_password',[UserController::class, 'forget_password']);
	

});

