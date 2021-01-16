<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\SaleController;
use App\Http\Middleware\EnsureTokenIsAdmin;
use App\Http\Middleware\EnsureTokenIsUserOrProfessional;

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
	Route::post('/create_admin/{id}',[UserController::class, 'create_admin'])->middleware(EnsureTokenIsAdmin::class);
	Route::post('/login',[UserController::class, 'login_user']);
	Route::post('/reset_password',[UserController::class, 'reset_password']);
	
});

Route::prefix('cards')->group(function () {
	Route::post('/create',[CardController::class, 'create_card'])->middleware(EnsureTokenIsAdmin::class);
	Route::post('/update/{id}',[CardController::class, 'update_card'])->middleware(EnsureTokenIsAdmin::class);
	Route::post('/add_card',[CardController::class, 'add_card_to_collection'])->middleware(EnsureTokenIsAdmin::class);

});

Route::prefix('collections')->group(function () {
	Route::post('/create',[CollectionController::class, 'create_collection'])->middleware(EnsureTokenIsAdmin::class);
	Route::post('/update/{id}',[CollectionController::class, 'update_collection'])->middleware(EnsureTokenIsAdmin::class);

});

Route::prefix('sales')->group(function () {
	Route::post('/create',[SaleController::class, 'create_sale'])->middleware(EnsureTokenIsUserOrProfessional::class);
	Route::post('/search',[SaleController::class, 'search_card'])->middleware(EnsureTokenIsUserOrProfessional::class);
	

});