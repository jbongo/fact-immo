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


Auth::routes();
Route::middleware('auth')->group(function(){
    Route::get('/product/add','ProductController@create')->name('product.add');
    Route::post('/product/store','ProductController@store')->name('product.store');
    Route::post('/picture/store/{product_id}','ProductController@storePicture')->name('picture.store');

    // Category
    Route::get('/category','CategoryController@index')->name('category.index');
    Route::post('/category/store','CategoryController@store')->name('category.store');
    Route::delete('/category/delete/{category}','CategoryController@destroy')->name('category.delete');
    Route::get('/category/delete/{category}','CategoryController@destroyNo')->name('category.delete');
    Route::put('/category/update/{category}','CategoryController@update')->name('category.update');





    Route::get('/', function () {
        return view('home');
    });
});

Route::get('/home', 'HomeController@index')->name('home');
