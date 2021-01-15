<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\CollectionController;
use App\Http\Middleware\EnsureTokenIsValid;

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
	Route::post('/reset_password',[UserController::class, 'reset_password']);
	

});

Route::prefix('cards')->group(function () {
	Route::post('/create',[CardController::class, 'create_card'])->middleware(EnsureTokenIsValid::class);
	Route::post('/update/{id}',[CardController::class, 'update_card']);
	Route::post('/add_card',[CardController::class, 'add_card_to_collection']);

});

Route::prefix('collections')->group(function () {
	Route::post('/create',[CollectionController::class, 'create_collection']);
	Route::post('/update/{id}',[CollectionController::class, 'update_collection']);

	

});