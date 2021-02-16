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

Route::get('/login', function (){
	return view('login');
});

Route::any('/signup', function(){
	return view('signup');
});

Route::any('/create_admin', function(){
	return view('create_admin');
});

Route::any('/create_card', function(){
	return view('create_card');
});

Route::any('/update_card', function(){
	return view('update_card');
});

Route::any('/add_card', function(){
	return view('add_card');
});

Route::get('/search_card', function(){
	return view('search_card');
});