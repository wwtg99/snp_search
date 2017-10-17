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

Route::view('/', 'home', ['title'=>'Home']);
Route::view('/home', 'home', ['title'=>'Home']);
Route::view('/search', 'home', ['title'=>'Home']);
Route::get('/view/{index}/{type}/{id}', 'ViewController@view');

//Route::get('/a', function() {
//    $d = \App\Models\MongoModel::find('rs587776435', 'testdb', 'ensemble');
//    dump($d);
//});