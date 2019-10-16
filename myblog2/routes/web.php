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
Route::get('/', 'UserApp\UserApp@selete');

Route::delete('/del/{id}', 'UserApp\UserApp@del');

Route::post('/edit','UserApp\UserApp@edit');

Route::get('/user/add',function(){
    return view('/UserAdd',['name'=>session('user')]);
});

Route::post('/add','UserApp\UserApp@userAdd');

Route::match(['get','post'],'/search','UserApp\UserApp@search');

Route::get('/login',function(){
    return view('/login');
});

Route::get('/reg',function (){
    return view('/register');
});

Route::post('/reg','UserApp\UserApp@userReg');

Route::post('/login','UserApp\UserApp@userLogin');
