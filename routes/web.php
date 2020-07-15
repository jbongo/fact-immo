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


Auth::routes(['register' => false]);
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
        Route::get('/mandataire/send-access/{mandataire_id}/{contrat_id}','MandataireController@send_access')->name('mandataire.send_access');

  
    // compromis  
    Route::get('/compromis','CompromisController@index')->name('compromis.index');
    Route::get('/compromis/from_dashboard/{annee}','CompromisController@index_from_dashboard')->name('compromis.index_from_dashboard');
    Route::get('/compromis/page_filleul','CompromisController@index')->name('compromis.filleul.index');
    Route::get('/compromis/create','CompromisController@create')->name('compromis.create');
    Route::post('/compromis/add','CompromisController@store')->name('compromis.add');
    Route::get('/compromis/show/{id}','CompromisController@show')->name('compromis.show');
    Route::get('/compromis/telecharger_pdf_compromis/{id}','CompromisController@telecharger_pdf_compromis')->name('compromis.telecharger_pdf_compromis');
    Route::put('/compromis/edit/{compromis}','CompromisController@edit')->name('compromis.edit');
    Route::post('/compromis/update/{compromis}','CompromisController@update')->name('compromis.update');
    Route::delete('/compromis/delete/{compromis}','CompromisController@destroy')->name('compromis.delete');
    Route::post('/compromis/archiver/{compromis}','CompromisController@archiver')->name('compromis.archiver');
    Route::get('/compromis/archive','CompromisController@archive')->name('compromis.archive');
    Route::post('/compromis/archive/restaurer/{compromis}','CompromisController@restaurer_archive')->name('compromis.archive.restaurer');
    Route::get('/compromis/cloturer/{compromis}','CompromisController@cloturer')->name('compromis.cloturer');
    // type affaire
    Route::get('/compromis/type','CompromisController@index_type_compromis')->name('compromis_type.index');


    

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
    Route::get('encaisser/factures-stylimmo/{facture}','FactureController@encaisser_facture_stylimmo')->name('facture.encaisser_facture_stylimmo');//ok
    Route::get('reencaisser/factures-stylimmo/','FactureController@reencaisser_facture_stylimmo')->name('facture.reencaisser_facture_stylimmo');//ok
    Route::get('regler/factures-honoraire/{facture}','FactureController@regler_facture_honoraire')->name('facture.regler_facture_honoraire');//ok

    // factures
    Route::get('/factures','FactureController@index')->name('facture.index');
    Route::get('/factures/create','FactureController@create')->name('facture.create');
    Route::get('/factures/packpub','FactureController@packpub')->name('facture.packpub');
    //  factures honoraire
    Route::get('preparer/factures-honoraire/{compromis}','FactureController@preparer_facture_honoraire')->name('facture.preparer_facture_honoraire');//ok
    Route::get('preparer/factures-honoraire-parrainage/{compromis}/{parrain_id?}','FactureController@preparer_facture_honoraire_parrainage')->name('facture.preparer_facture_honoraire_parrainage');//ok
    // Parrain du partage
    // Route::get('preparer/factures-honoraire-parrainage-partage/{compromis}','FactureController@preparer_facture_honoraire_parrainage_partage')->name('facture.preparer_facture_honoraire_parrainage_partage');//ok
    Route::get('preparer/factures-honoraire-partage/{compromis}/{mandataire_id?}','FactureController@preparer_facture_honoraire_partage')->name('facture.preparer_facture_honoraire_partage');//ok
    Route::post('deduire-pub/factures-honoraire/{compromis}','FactureController@deduire_pub_facture_honoraire')->name('facture.deduire_pub_facture_honoraire');//ok
    Route::post('deduire-pub/factures-honoraire-partage/{compromis}/{mandataire_id?}','FactureController@deduire_pub_facture_honoraire_partage')->name('facture.deduire_pub_facture_honoraire_partage');//ok
    // Route::get('generer/pdf/factures-honoraire/','FactureController@generer_pdf_facture_honoraire')->name('facture.pdf.generer_facture_honoraire');
    // Facture d'avoir
    Route::get('/factures/avoir/create/{facture_id}','FactureController@create_avoir')->name('facture.avoir.create');
    Route::post('/factures/avoir/store/','FactureController@store_avoir')->name('facture.avoir.store');
    Route::get('/factures/avoir/show/{facture_id}','FactureController@show_avoir')->name('facture.avoir.show');
    Route::get('generer/pdf/avoir/','FactureController@generer_pdf_avoir')->name('facture.pdf.generer_avoir');
    Route::get('telecharger/pdf/avoir/{avoir_id}','FactureController@download_pdf_avoir')->name('facture.telecharger_pdf_avoir'); //ok

    // ## Creation des factures d'honoraires
    Route::get('facture/honoraire/generer/create/{facture_id}','FactureController@generer_facture_honoraire_create')->name('facture.generer_honoraire_create'); 
    Route::get('facture/honoraire/generer-pdf/{facture_id}','FactureController@generer_pdf_facture_honoraire')->name('facture.generer_pdf_honoraire'); 
    // Ajout d'une factue d'honoraire 
    Route::get('facture/honoraire/upload/create/{facture_id}','FactureController@create_upload_pdf_honoraire')->name('facture.create_upload_pdf_honoraire'); 
    Route::post('facture/honoraire/upload/store/{facture_id}','FactureController@store_upload_pdf_honoraire')->name('facture.store_upload_pdf_honoraire'); 
    Route::get('facture/honoraire/valider/{action}/{facture_id}','FactureController@valider_honoraire')->name('facture.valider_honoraire'); 
    // Factures d'honoraires à valider
    Route::get('facture/honoraire/a_valider/','FactureController@honoraire_a_valider')->name('facture.honoraire_a_valider'); 
    //Telecharger les factures
    Route::get('telecharger/pdf/factures/{facture_id}','FactureController@download_pdf_facture')->name('facture.telecharger_pdf_facture'); //ok
    // Recalculer une note d'honoraire
    Route::get('facture/honoraire/recalculer/{facture_id}','FactureController@recalculer_honoraire')->name('facture.recalculer_honoraire'); 
     // Recalculer pour chacun des mandataires les CA stylimmo
    Route::get('ca/stylimmo/recalculer/','FactureController@recalculer_les_ca_styl')->name('facture.recalculer_les_ca_styl'); 
    


    
     
    // Contrat 
    Route::get('/contrat/create/{user_id}','ContratController@create')->name('contrat.create');
    Route::get('/contrat/model/create/{user_id}','ContratController@model_create')->name('contrat.model_create');
    Route::post('/contrat/add','ContratController@store')->name('contrat.add');
    Route::get('/contrat/edit/{contrat_id}','ContratController@edit')->name('contrat.edit');
    Route::post('/contrat/update/{contrat_id}','ContratController@update')->name('contrat.update');

   
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
    // Pramètre généraux
    Route::get('parametre/generaux/create','ParametreController@create_parametre_generaux')->name('parametre_generaux.create');
    Route::post('parametre/generaux/store','ParametreController@store_parametre_generaux')->name('parametre_generaux.store');
    Route::post('parametre/generaux/update','ParametreController@update_parametre_generaux')->name('parametre_generaux.update');


    // ##### CALCUL STATS TEST
    
    Route::get('stats/mandataire/{mandataire_id}','MandataireController@stats_user')->name('stats_user');
    Route::post('stats/mandataire/{mandataire_id}','MandataireController@store_parrain')->name('store.parrain');

    // ####### EXPORT FACTURE
    Route::get('export/liste/','FactureController@export_facture')->name('export_facture.index');



    // ###### tests cronjob
    Route::get('pourcentage_parrain/','FilleulController@pourcentage_parrain')->name('filleul.pourcentage_parrain');

    
    Route::get('/', function () {
        return view('home');
    });
    Route::get('/home/{annee?}', 'HomeController@index')->name('home');       
    Route::get('/', 'HomeController@index')->name('home');       
  
    

    // Se connecter sur une autre session utilisateur

    Route::get('/switch/{user_id}','MandataireController@switch_user')->name('switch_user');
    Route::get('/unswitch','MandataireController@unswitch_user')->name('unswitch_user');
});

