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
    Route::get('/mandataires','MandataireController@index')->name('mandataire.index');
    Route::get('/mandataire/create','MandataireController@create')->name('mandataire.create');
    Route::post('/mandataire/add','MandataireController@store')->name('mandataire.add');
    Route::get('/mandataire/show/{id}','MandataireController@show')->name('mandataire.show');
    Route::get('/mandataire/edit/{mandataire}','MandataireController@edit')->name('mandataire.edit');
    Route::post('/mandataire/update/{mandataire}','MandataireController@update')->name('mandataire.update');
    Route::delete('/mandataire/delete/{mandataire}','MandataireController@destroy')->name('mandataire.delete');
    Route::delete('/mandataire/archive/{mandataire}','MandataireController@archive')->name('mandataire.archive');
    
    // compromis
    Route::get('/compromis','CompromisController@index')->name('compromis.index');
    Route::get('/compromis/create','CompromisController@create')->name('compromis.create');
    Route::post('/compromis/add','CompromisController@store')->name('compromis.add');
    Route::get('/compromis/show/{id}','CompromisController@show')->name('compromis.show');
    Route::put('/compromis/edit/{compromis}','CompromisController@edit')->name('compromis.edit');
    Route::post('/compromis/update/{compromis}','CompromisController@update')->name('compromis.update');
    Route::delete('/compromis/delete/{compromis}','CompromisController@destroy')->name('compromis.delete');
    Route::delete('/compromis/archive/{compromis}','CompromisController@archive')->name('compromis.archive');

    // demandes factures stylimmo
    Route::get('/demander/factures/{compromis}','factureController@demander_facture')->name('facture.demander_facture');//ok
    Route::post('/demander/factures/{compromis}','factureController@store_demande_facture')->name('facture.demander_facture');//ok
    Route::get('/demande/factures','factureController@demandes_stylimmo')->name('facture.demande_stylimmo');
    Route::get('show/demande/factures/{compromis}','factureController@show_demande_stylimmo')->name('facture.show_demande_stylimmo');//ok
    Route::get('generer/factures-stylimmo/{compromis}','factureController@generer_facture_stylimmo')->name('facture.generer_facture_stylimmo');
    Route::get('generer/pdf/factures-stylimmo/','factureController@generer_pdf_facture_stylimmo')->name('facture.pdf.generer_facture_stylimmo');
    Route::get('telecharger/pdf/factures-stylimmo/{compromis_id}','factureController@download_pdf_facture_stylimmo')->name('facture.telecharger_pdf_facture_stylimmo'); //ok
    Route::post('envoyer/factures-stylimmo/{facture}','factureController@envoyer_facture_stylimmo')->name('facture.envoyer_facture_stylimmo');

     // factures
     Route::get('/factures','factureController@index')->name('facture.index');
     Route::get('/factures/create','factureController@create')->name('facture.create');

     
    // Contrat 
    Route::get('/contrat/create/{user_id}','ContratController@create')->name('contrat.create');
    Route::post('/contrat/add','ContratController@store')->name('contrat.add');

    // Commissions
    Route::get('commissions/','CommissionController@index')->name('commissions.index');
    Route::post('commissions/create','CommissionController@create')->name('commissions.create');
   

    Route::get('/', function () {
        return view('home');
    });
});

Route::get('/home', 'HomeController@index')->name('home');
