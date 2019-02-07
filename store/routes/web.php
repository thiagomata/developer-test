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

Route::get('/','CartController@show')->name("cart.show");
Route::get('/add/{product_id}/{quantity}','CartController@add')->name("cart.add.product.id");
Route::get('/add/{product_name}/{product_price}/{quantity}','CartController@createAndAdd')->name("cart.add.product.name");
Route::get('/remove/{product_id}','CartController@remove')->name("cart.remove.product.id");
Route::get('/remove/{product_name}/{product_price}','CartController@removeByName')->name("cart.remove.product.name");
