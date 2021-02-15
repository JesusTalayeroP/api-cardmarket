<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Route::get('/main', function (){
	return view('main');
});

Route::post('/signup', function(){
	return view('signup');
});

Route::post('/create_admin/{id}', function(){
	return view('create_admin');
});

Route::post('/create_card', function(){
	return view('create_card');
});

Route::post('/update_card{id}', function(){
	return view('update_card');
});

Route::post('/add_card', function(){
	return view('add_card');
});

Route::post('/create_collection', function(){
	return view('create_collection');
});

Route::post('/update_collection/{id}', function(){
	return view('update_collection');
});

Route::get('/search_card/{card_name}', function(){
	return view('search_card');
});