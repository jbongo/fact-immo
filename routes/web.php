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
    Route::post('/compromis/cloturer/{compromis}','CompromisController@cloturer')->name('compromis.cloturer');

    // demandes factures stylimmo
    
    Route::get('/demander/factures/{compromis}','FactureController@demander_facture')->name('facture.demander_facture');//ok
    Route::post('/demander/factures/{compromis}','FactureController@store_demande_facture')->name('facture.demander_facture');//ok
    Route::get('/demande/factures','FactureController@demandes_stylimmo')->name('facture.demande_stylimmo');
    Route::get('show/demande/factures/{compromis}','FactureController@show_demande_stylimmo')->name('facture.show_demande_stylimmo');//ok
    Route::get('valider/factures-stylimmo/{compromis}','FactureController@valider_facture_stylimmo')->name('facture.valider_facture_stylimmo');//ok
    Route::get('generer/factures-stylimmo/{compromis}','FactureController@generer_facture_stylimmo')->name('facture.generer_facture_stylimmo');//ok
    Route::get('generer/pdf/factures-stylimmo/','FactureController@generer_pdf_facture_stylimmo')->name('facture.pdf.generer_facture_stylimmo');
    Route::get('telecharger/pdf/factures-stylimmo/{compromis_id}','FactureController@download_pdf_facture_stylimmo')->name('facture.telecharger_pdf_facture_stylimmo'); //ok
    Route::get('envoyer/factures-stylimmo/{facture}','FactureController@envoyer_facture_stylimmo')->name('facture.envoyer_facture_stylimmo');//ok
    Route::post('encaisser/factures-stylimmo/{facture}','FactureController@encaisser_facture_stylimmo')->name('facture.encaisser_facture_stylimmo');//ok
    // factures
    Route::get('/factures','FactureController@index')->name('facture.index');
    Route::get('/factures/create','FactureController@create')->name('facture.create');
    Route::get('/factures/packpub','FactureController@packpub')->name('facture.packpub');
    //  factures honoraire
    Route::get('preparer/factures-honoraire/{compromis}','FactureController@preparer_facture_honoraire')->name('facture.preparer_facture_honoraire');//ok
    Route::post('deduire-pub/factures-honoraire/{compromis}','FactureController@deduire_pub_facture_honoraire')->name('facture.deduire_pub_facture_honoraire');//ok
    // Route::get('generer/pdf/factures-honoraire/','FactureController@generer_pdf_facture_honoraire')->name('facture.pdf.generer_facture_honoraire');
     
    // Contrat 
    Route::get('/contrat/create/{user_id}','ContratController@create')->name('contrat.create');
    Route::get('/contrat/model/create/{user_id}','ContratController@model_create')->name('contrat.model_create');
    Route::post('/contrat/add','ContratController@store')->name('contrat.add');

   
    // ##### PARAMETRE #######
    // Pack pub
    Route::get('parametre/pack_pub/','PackpubController@index')->name('pack_pub.index');
    Route::get('parametre/pack_pub/edit/{pack_pub}','PackpubController@edit')->name('pack_pub.edit');
    Route::get('parametre/pack_pub/create','PackpubController@create')->name('pack_pub.create');
    Route::post('parametre/pack_pub/store','PackpubController@store')->name('pack_pub.store');
    Route::post('parametre/pack_pub/update/{pack_pub}','PackpubController@update')->name('pack_pub.update');
    
    // Modèle contrat
    
    Route::get('parametre/modele_contrat/create','ContratController@create_model_contrat')->name('modele_contrat.create');
    Route::post('parametre/modele_contrat/store','ContratController@store_model_contrat')->name('modele_contrat.store');
    Route::post('parametre/modele_contrat/update','ContratController@update_model_contrat')->name('modele_contrat.update');


    Route::get('/', function () {
        return view('home');
    });
    Route::get('/home', 'HomeController@index')->name('home');
});

