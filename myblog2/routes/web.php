<?php

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
Route::get('/', 'UserController\UserController@select');

Route::delete('/del/{id}', 'UserController\UserController@del');

Route::match(['get','post'],'/user/edit','UserController\UserController@edit');

Route::get('/user/add',function(){
    return view('/UserAdd',['name'=>session('user')]);
});

Route::post('/add','UserController\UserController@userAdd');

Route::match(['get','post'],'/search','UserController\UserController@search');

Route::get('/login',function(){
    return view('/login');
});

Route::get('/reg',function (){
    return view('/register');
});

Route::post('/reg','UserController\UserController@userReg');

Route::post('/login','UserController\UserController@userLogin');

Route::get('/out','UserController\UserController@out');
