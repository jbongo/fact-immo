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

    // Mandataires
    Route::get('/mandataires','mandataireController@index')->name('mandataire.index');
    Route::get('/mandataire/create','mandataireController@create')->name('mandataire.create');
    Route::post('/mandataire/add','mandataireController@store')->name('mandataire.add');
    Route::get('/mandataire/show/{id}','mandataireController@show')->name('mandataire.show');
    Route::put('/mandataire/edit/{mandataire}','mandataireController@edit')->name('mandataire.edit');
    Route::put('/mandataire/update/{mandataire}','mandataireController@update')->name('mandataire.update');
    Route::delete('/mandataire/delete/{mandataire}','mandataireController@destroy')->name('mandataire.delete');
    Route::delete('/mandataire/archive/{mandataire}','mandataireController@archive')->name('mandataire.archive');

    // Contrat 
    Route::get('/contrat/create','contratController@create')->name('contrat.create');
    Route::post('/contrat/add','contratController@store')->name('contrat.add');


    Route::get('/', function () {
        return view('home');
    });
});

Route::get('/home', 'HomeController@index')->name('home');
