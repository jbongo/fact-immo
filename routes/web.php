<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
   
    Route::get('/mandataires','MandataireController@index')->name('mandataire.index')->middleware('admin');
    Route::get('/mandataire/create','MandataireController@create')->name('mandataire.create')->middleware('admin');
    Route::post('/mandataire/add','MandataireController@store')->name('mandataire.add')->middleware('admin');
    Route::get('/mandataire/show/{id}','MandataireController@show')->name('mandataire.show');
    Route::get('/mandataire/edit/{mandataire}','MandataireController@edit')->name('mandataire.edit')->middleware('admin');
    Route::post('/mandataire/update/{mandataire}','MandataireController@update')->name('mandataire.update');
    Route::delete('/mandataire/delete/{mandataire}','MandataireController@destroy')->name('mandataire.delete');
    Route::delete('/mandataire/archive/{mandataire}','MandataireController@archive')->name('mandataire.archive');
    Route::get('/mandataire/send-access/{mandataire_id}/{contrat_id}','MandataireController@send_access')->name('mandataire.send_access');
    Route::post('/mandataire/activer/{mandataire}','MandataireController@activer')->name('mandataire.activer');
    
    // Prospects
    
    Route::get('/prospects','ProspectController@index')->name('prospect.index')->middleware('supervisor');
    Route::get('/prospect/create','ProspectController@create')->name('prospect.create')->middleware('supervisor');
    Route::post('/prospect/add','ProspectController@store')->name('prospect.add')->middleware('supervisor');
    Route::get('/prospect/show/{id}','ProspectController@show')->name('prospect.show')->middleware('supervisor');
    Route::get('/prospect/edit/{prospect}','ProspectController@edit')->name('prospect.edit')->middleware('supervisor');
    Route::post('/prospect/update/{prospect}','ProspectController@update')->name('prospect.update')->middleware('supervisor');
    Route::delete('/prospect/delete/{prospect}','ProspectController@destroy')->name('prospect.delete');
    Route::get('/prospect/archives/','ProspectController@archives')->name('prospect.archives');
    Route::get('/prospect/archiver/{prospect}/{action}','ProspectController@archiver')->name('prospect.archiver');
    Route::get('/prospects/agenda','ProspectController@agenda_general')->name('prospect.agenda');
    Route::get('/prospect/agenda/{prospect_id}','ProspectController@show_agenda_prospect')->name('prospect.agenda.show')->middleware('supervisor');
    Route::post('/prospect/agenda/store','ProspectController@store_agenda_prospect')->name('prospect.agenda.store')->middleware('supervisor');
    Route::post('/prospect/agenda/update','ProspectController@update_agenda_prospect')->name('prospect.agenda.update')->middleware('supervisor');
    
    
    Route::get('/prospect/telecharger/{url}/{type}','ProspectController@telecharger_doc')->name('prospect.telecharger');
    Route::get('/prospect/envoi-mail-fiche/{prospect}','ProspectController@envoi_mail_fiche')->name('prospect.envoi_mail_fiche');
    Route::get('/prospect/a_mandataire/{prospect}','ProspectController@prospect_a_mandataire')->name('prospect.prospect_a_mandataire');
    
    Route::get('/contrat/modele/','ProspectController@modele_contrat')->name('prospect.modele');
    Route::get('/contrat/envoyer/modele/{prospect}','ProspectController@envoyer_modele_contrat')->name('prospect.envoyer_modele_contrat');
    Route::get('/contrat/telecharger/modele/{prospect}','ProspectController@telecharger_modele_contrat')->name('prospect.telecharger_modele_contrat');
    
        
    // Gestion des Jetons
    Route::get('/mandataires/jetons','MandataireController@mandataires_jetons')->name('mandataires.jetons')->middleware('admin');
    Route::get('/historique-jeton/{user_id}','MandataireController@historique_jeton')->name('mandataire.historique_jeton');
    Route::post('/jetons/update/{user_id}','MandataireController@update_jetons')->name('jetons.update');
    // Gestion des factures pub
    Route::get('/mandataires/facture-pub','MandataireController@mandataires_facture_pub')->name('mandataires.facture_pub')->middleware('admin');
    Route::get('/historique-facture-pub/{user_id}','MandataireController@historique_facture_pub')->name('mandataire.historique_facture_pub');
    
    // Gestion des parrainages
    Route::get('/parrainage','ParrainageController@index')->name('parrainage.index')->middleware('admin');
 
    // compromis  
    Route::get('/compromis','CompromisController@index')->name('compromis.index');
    Route::get('/compromis/from_dashboard/{annee}','CompromisController@index_from_dashboard')->name('compromis.index_from_dashboard');
    Route::get('/compromis/from_dashboard/mes_affaires/{annee}','CompromisController@index_from_dashboard_mes_affaires')->name('compromis.index_from_dashboard_mes_affaires');
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
    Route::get('/compromis/etat/{compromis}','CompromisController@etat_compromis')->name('compromis.etat');
    Route::get('/compromis/modifer-date-vente/{compromis}','CompromisController@modifier_date_vente')->name('compromis.modifier_date_vente');
    // type affaire
    Route::get('/compromis/type','CompromisController@index_type_compromis')->name('compromis_type.index');
   
    // Affaires cloturées
    Route::get('/affaires-clotures','CompromisController@affaire_cloture')->name('compromis.affaire_cloture');

    // Affaire en cours
    Route::get('/affaires-toutes','CompromisController@affaire_toutes')->name('compromis.affaire_toutes');


    

    // demandes factures stylimmo
    
    Route::get('/demander/factures/{compromis}','FactureController@demander_facture')->name('facture.demander_facture');//ok
    Route::post('/demander/factures/{compromis}','FactureController@store_demande_facture')->name('facture.demander_facture');//ok
    Route::get('/demande/factures','FactureController@demandes_stylimmo')->name('facture.demande_stylimmo');
    Route::get('show/demande/factures/{compromis}','FactureController@show_demande_stylimmo')->name('facture.show_demande_stylimmo');//ok
    Route::get('valider/factures-stylimmo/{compromis}','FactureController@valider_facture_stylimmo')->name('facture.valider_facture_stylimmo');//ok
    Route::get('generer/factures-stylimmo/{compromis}','FactureController@generer_facture_stylimmo')->name('facture.generer_facture_stylimmo');//ok
    Route::get('generer/pdf/factures-stylimmo/','FactureController@generer_pdf_facture_stylimmo')->name('facture.pdf.generer_facture_stylimmo');
    Route::get('telecharger/pdf/factures-stylimmo/{facture_id}','FactureController@download_pdf_facture_stylimmo')->name('facture.telecharger_pdf_facture_stylimmo'); //ok
    Route::get('envoyer/factures-stylimmo/{facture}','FactureController@envoyer_facture_stylimmo')->name('facture.envoyer_facture_stylimmo');//ok
    Route::get('encaisser/factures-stylimmo/{facture}','FactureController@encaisser_facture_stylimmo')->name('facture.encaisser_facture_stylimmo');//ok
    Route::get('reencaisser/factures-stylimmo/','FactureController@reencaisser_facture_stylimmo')->name('facture.reencaisser_facture_stylimmo');//ok
    Route::get('regler/factures-honoraire/{facture}','FactureController@regler_facture_honoraire')->name('facture.regler_facture_honoraire');//ok

    // factures
    Route::get('/factures','FactureController@index')->name('facture.index');
    Route::get('/factures/all','FactureController@index_all')->name('facture.index_all')->middleware('admin');
    Route::get('/factures/hors-delais','FactureController@hors_delais')->name('facture.hors_delais');
    Route::get('/factures/create','FactureController@create')->name('facture.create');
    Route::get('/factures/packpub','FactureController@packpub')->name('facture.packpub');
    
    Route::get('/factures/stylimmo','FactureController@index_stylimmo')->name('facture.index_stylimmo');
    Route::get('/factures/pub','FactureController@index_pub')->name('facture.index_pub');
    
    Route::get('/factures/honoraire','FactureController@index_honoraire')->name('facture.index_honoraire');
    Route::get('/factures/honoraire_encaissee/{annee}','FactureController@index_honoraire_encaissee')->name('facture.index_honoraire_encaissee');
    Route::get('/factures/honoraire_en_attente/{annee}','FactureController@index_honoraire_en_attente')->name('facture.index_honoraire_en_attente');
    Route::get('/factures/communication','FactureController@index_communication')->name('facture.index_communication');
    Route::get('/factures/fournisseur','FactureController@index_fournisseur')->name('facture.index_fournisseur');
    
    Route::get('/factures/relance/{facture_id}','FactureController@relancer_paiement_facture')->name('facture.relancer_paiement_facture');
    
    


    //  factures honoraire
    Route::get('preparer/factures-honoraire/{compromis}','FactureController@preparer_facture_honoraire')->name('facture.preparer_facture_honoraire');//ok
    Route::get('preparer/factures-honoraire-parrainage/{compromis}/{parrain_id?}','FactureController@preparer_facture_honoraire_parrainage')->name('facture.preparer_facture_honoraire_parrainage');//ok
    // Parrain du partage
    // Route::get('preparer/factures-honoraire-parrainage-partage/{compromis}','FactureController@preparer_facture_honoraire_parrainage_partage')->name('facture.preparer_facture_honoraire_parrainage_partage');//ok
    Route::get('preparer/factures-honoraire-partage/{compromis}/{mandataire_id?}','FactureController@preparer_facture_honoraire_partage')->name('facture.preparer_facture_honoraire_partage');//ok
    // Pour les partage externe (facture honoraire de l'agence externe)
    Route::get('preparer/factures-honoraire-partage-externe/{compromis}/{mandataire_id?}','FactureController@preparer_facture_honoraire_partage_externe')->name('facture.preparer_facture_honoraire_partage_externe');//ok
    Route::post('deduire-pub/factures-honoraire/{compromis}','FactureController@deduire_pub_facture_honoraire')->name('facture.deduire_pub_facture_honoraire');//ok
    Route::post('deduire-pub/factures-honoraire-partage/{compromis}/{mandataire_id?}','FactureController@deduire_pub_facture_honoraire_partage')->name('facture.deduire_pub_facture_honoraire_partage');//ok
    
    // Liste des fact pub à valider
    Route::get('/factures/pub-a-valider','FactpubController@pub_a_valider')->name('facture.pub_a_valider');
    Route::get('/factures/generer-fact-pub/{facture_id}','FactpubController@generer_fact_pub')->name('facture.generer_fact_pub');
    // Route::get('/factures/generer-pdf-fact-pub/{facture_id}','FactpubController@generer_pdf_fact_pub')->name('facture.generer_pdf_fact_pub');
    Route::get('telecharger/pdf/factures-fact-pub/{facture_id}','FactpubController@download_pdf_facture_fact_pub')->name('facture.telecharger_pdf_facture_fact_pub'); //ok
    

    Route::get('/factures/valider-fact-pub/{fact_pub_id}/{validation}','FactpubController@valider_fact_pub')->name('facture.valider_fact_pub');
    Route::get('/factures/valider-facts-pub/plusieurs/{validation}','FactpubController@valider_fact_pub_plusieurs')->name('facture.valider_fact_pub_plusieurs');
    Route::get('/factures/recalculer-fact-pub/{fact_pub_id}','FactpubController@recalculer_fact_pub')->name('facture.recalculer_fact_pub');
    
    
    // Lorsqu'on déduis la pub sans supprimer la facture 
    Route::get('deduire-pub-show/factures/{facture_id}','FactureController@deduire_pub_show')->name('facture.deduire_pub_show');//ok
    Route::post('deduire-pub/factures/{facture_id}','FactureController@deduire_pub')->name('facture.deduire_pub');//ok
    

    // Facture d'avoir
    Route::get('/factures/avoir/create/{facture_id}','FactureController@create_avoir')->name('facture.avoir.create');
    Route::post('/factures/avoir/store/','FactureController@store_avoir')->name('facture.avoir.store');
    Route::get('/factures/avoir/show/{facture_id}','FactureController@show_avoir')->name('facture.avoir.show');
    Route::get('generer/pdf/avoir/{facture_id}','FactureController@generer_pdf_avoir')->name('facture.pdf.generer_avoir');
    Route::get('generer/avoir/stylimmo/{facture_id}','FactureController@generer_avoir_stylimmo')->name('facture.generer_avoir_stylimmo');
    Route::get('telecharger/pdf/avoir/{avoir_id}','FactureController@download_pdf_avoir')->name('facture.telecharger_pdf_avoir'); //ok



    // ## Creation des factures d'honoraires
    Route::get('facture/honoraire/generer/create/{facture_id}','FactureController@generer_facture_honoraire_create')->name('facture.generer_honoraire_create'); 
    Route::get('facture/honoraire/generer-pdf/{facture_id}','FactureController@generer_pdf_facture_honoraire')->name('facture.generer_pdf_honoraire'); 
    // Ajout d'une facture d'honoraire 
    Route::get('facture/honoraire/upload/create/{facture_id}','FactureController@create_upload_pdf_honoraire')->name('facture.create_upload_pdf_honoraire'); 
    Route::post('facture/honoraire/upload/store/{facture_id}','FactureController@store_upload_pdf_honoraire')->name('facture.store_upload_pdf_honoraire'); 
    Route::get('facture/honoraire/valider/{action}/{facture_id}','FactureController@valider_honoraire')->name('facture.valider_honoraire'); 
    Route::post('facture/honoraire/valider/{action}/{facture_id}','FactureController@valider_honoraire_motif')->name('facture.valider_honoraire'); 
    // Factures d'honoraires à valider
    Route::get('facture/honoraire/a_valider/','FactureController@honoraire_a_valider')->name('facture.honoraire_a_valider'); 
    //Telecharger les factures
    Route::get('telecharger/pdf/factures/{facture_id}','FactureController@download_pdf_facture')->name('facture.telecharger_pdf_facture'); //ok
    // Télecharger le rib  del'agence externe
    Route::get('telecharger/pdf/rib/{facture_id}','FactureController@download_pdf_rib')->name('facture.telecharger_pdf_rib'); //ok
    // Recalculer une note d'honoraire
    Route::get('facture/honoraire/recalculer/{facture_id}','FactureController@recalculer_honoraire')->name('facture.recalculer_honoraire'); 
     // Recalculer pour chacun des mandataires les CA stylimmo
    Route::get('ca/stylimmo/recalculer/','FactureController@recalculer_les_ca_styl')->name('facture.recalculer_les_ca_styl'); 
    
     // Factures d'honoraires à payer
     Route::get('facture/honoraire/a-payer/','FactureController@honoraire_a_payer')->name('facture.honoraire_a_payer'); 
    

    //  Creation de factures libres
    Route::get('facture/ajouter-libre/','FactureController@create_libre')->name('facture.create_libre'); 
    Route::post('facture/add-libre/','FactureController@store_libre')->name('facture.store_libre'); 
    Route::get('facture/edit-libre/{facture_id}','FactureController@edit_libre')->name('facture.edit_libre'); 
    Route::post('facture/update-libre/{facture_id}','FactureController@update_libre')->name('facture.update_libre'); 
    
    Route::get('telecharger/pdf/factures-autre/{facture_id}','FactureController@download_pdf_facture_autre')->name('facture.telecharger_pdf_facture_autre'); //ok
    Route::get('generer/pdf/factures-autre/{facture_id}','FactureController@generer_pdf_facture_autre')->name('facture.generer_pdf_facture_autre'); //ok
    


    // Contrat 
    Route::get('/contrat/create/{user_id}','ContratController@create')->name('contrat.create');
    Route::get('/contrat/model/create/{user_id}','ContratController@model_create')->name('contrat.model_create');
    Route::post('/contrat/add','ContratController@store')->name('contrat.add');
    Route::get('/contrat/edit/{contrat_id}','ContratController@edit')->name('contrat.edit');
    Route::post('/contrat/update/{contrat_id}','ContratController@update')->name('contrat.update');
    Route::get('/contrat/maj_date_anniversaire/','ContratController@maj_date_anniversaire')->name('contrat.maj_date_anniversaire');
    Route::get('/contrat/historique/{contrat_id}','ContratController@historique')->name('contrat.historique');
    Route::get('/contrat/historique/show/{contrat_id}','ContratController@historique_show')->name('contrat.historique.show');
    Route::get('/contrat/reinitialiser/{contrat_id}','ContratController@reinitialiser')->name('contrat.reinitialiser');
     
    Route::get('/contrat/telecharger/{contrat_id}','ContratController@telecharger_contrat')->name('contrat.telecharger');
    Route::get('/historiquecontrat/telecharger/{contrat_id}','ContratController@telecharger_historiquecontrat')->name('historiquecontrat.telecharger');
    Route::get('/contrat/envoyer-contrat-mail/','ContratController@envoyer_contrat_mail')->name('contrat.envoyer_contrat_mail');
    Route::get('/contrat/envoyer-contrat-non-signe-mail/{contrat_id}','ContratController@envoyer_contrat_non_signe_mail')->name('contrat.envoyer_contrat_non_signe_mail');
    Route::get('/contrat/telecharger-contrat-non-signe/{contrat_id}','ContratController@telecharger_contrat_non_signe')->name('contrat.telecharger_contrat_non_signe');
    
    
    // 


   
    // ##### PARAMETRE #######
    // Pack pub
    Route::get('parametre/pack_pub/','PackpubController@index')->name('pack_pub.index');
    Route::get('parametre/pack_pub/edit/{pack_pub}','PackpubController@edit')->name('pack_pub.edit');
    Route::get('parametre/pack_pub/create','PackpubController@create')->name('pack_pub.create');
    Route::post('parametre/pack_pub/store','PackpubController@store')->name('pack_pub.store');
    Route::post('parametre/pack_pub/update/{pack_pub}','PackpubController@update')->name('pack_pub.update');    
    Route::get('parametre/pack_pub/archiver/{pack_pub}/{action?}','PackpubController@archiver')->name('pack_pub.archiver');    
    // Modèle contrat    
    Route::get('parametre/modele_contrat/create','ContratController@create_model_contrat')->name('modele_contrat.create');
    Route::post('parametre/modele_contrat/store','ContratController@store_model_contrat')->name('modele_contrat.store');
    Route::post('parametre/modele_contrat/update','ContratController@update_model_contrat')->name('modele_contrat.update');
    // Paramètre généraux
    Route::get('parametre/generaux/create','ParametreController@create_parametre_generaux')->name('parametre_generaux.create');
    Route::post('parametre/generaux/store','ParametreController@store_parametre_generaux')->name('parametre_generaux.store');
    Route::post('parametre/generaux/update','ParametreController@update_parametre_generaux')->name('parametre_generaux.update');

    // Paramètre barême d'honoraire
    Route::get('parametre/bareme-honoraire/','BaremehonoraireController@index')->name('bareme_honoraire.index');
    Route::get('parametre/bareme-honoraire/create','BaremehonoraireController@create')->name('bareme_honoraire.create');
    Route::get('parametre/bareme-honoraire/edit/{bareme_id}','BaremehonoraireController@edit')->name('bareme_honoraire.edit');
    Route::post('parametre/bareme-honoraire/store','BaremehonoraireController@store')->name('bareme_honoraire.store');
    Route::post('parametre/bareme-honoraire/update/{bareme_id}','BaremehonoraireController@update')->name('bareme_honoraire.update');
    Route::delete('parametre/bareme-honoraire/delete/{bareme_id}','BaremehonoraireController@delete')->name('bareme_honoraire.delete');
    

    // Fournisseur
    Route::get('fournisseurs','FournisseurController@index')->name('fournisseur.index');
    // Route::get('fournisseur/type/{type?}','FournisseurController@index')->name('fournisseur.index');
    Route::get('fournisseur/edit/{fournisseur_id}','FournisseurController@edit')->name('fournisseur.edit');
    Route::get('fournisseur/show/{fournisseur_id}','FournisseurController@show')->name('fournisseur.show');
    Route::post('fournisseur/update/{fournisseur_id}','FournisseurController@update')->name('fournisseur.update');
    Route::get('fournisseur/create','FournisseurController@create')->name('fournisseur.create');
    Route::post('fournisseur/store','FournisseurController@store')->name('fournisseur.store');
    
    // Facturefournisseur

     Route::get('fournisseur/facture/edit/{facturefournisseur_id}','FournisseurController@edit_facture')->name('fournisseur.facture.edit');
     Route::post('fournisseur/facture/update/{facturefournisseur_id}','FournisseurController@update_facture')->name('fournisseur.facture.update');
     Route::get('fournisseur/facture/create/{fournisseur_id}','FournisseurController@create_facture')->name('fournisseur.facture.create');
     Route::post('fournisseur/facture/store','FournisseurController@store_facture')->name('fournisseur.facture.store');
     Route::get('fournisseur/facture/archiver/facturefournisseur_id}','FournisseurController@archiver_facture')->name('fournisseur.facture.archiver'); 
     
     // Contratfournisseur

     Route::get('fournisseur/contrat/edit/{contratfournisseur_id}','ContratfournisseurController@edit')->name('fournisseur.contrat.edit');
     Route::post('fournisseur/contrat/update/{contratfournisseur_id}','ContratfournisseurController@update')->name('fournisseur.contrat.update');
     Route::get('fournisseur/contrat/create/{fournisseur_id}','ContratfournisseurController@create')->name('fournisseur.contrat.create');
     Route::post('fournisseur/contrat/store','ContratfournisseurController@store')->name('fournisseur.contrat.store');
     Route::get('fournisseur/contrat/archiver/{contratfournisseur_id}','ContratfournisseurController@archiver')->name('fournisseur.contrat.archiver'); 
     
     // Commandefournisseur

     Route::get('fournisseur/commande/edit/{commandefournisseur_id}','CommandefournisseurController@edit')->name('fournisseur.commande.edit');
     Route::post('fournisseur/commande/update/{commandefournisseur_id}','CommandefournisseurController@update')->name('fournisseur.commande.update');
     Route::get('fournisseur/commande/create/{fournisseur_id}','CommandefournisseurController@create')->name('fournisseur.commande.create');
     Route::post('fournisseur/commande/store','CommandefournisseurController@store')->name('fournisseur.commande.store');
     Route::get('fournisseur/commande/archiver/{commandefournisseur_id}','CommandefournisseurController@archiver')->name('fournisseur.commande.archiver'); 
     
    // Article
    Route::get('articles/{fournisseur}','ArticleController@index')->name('article.index');
    Route::get('article/edit/{article}','ArticleController@edit')->name('article.edit');
    Route::post('article/update/{article}','ArticleController@update')->name('article.update');
    Route::get('article/create/{fournisseur}','ArticleController@create')->name('article.create');
    Route::post('article/store','ArticleController@store')->name('article.store');
    Route::get('/article/historique/{article_id}','ArticleController@historique')->name('article.historique');
    Route::get('/article/historique/show/{article_id}','ArticleController@historique_show')->name('article.historique.show');
    Route::get('article/archiver/{article}','ArticleController@archiver')->name('article.archiver');
    
    // Passerelles ou articles de type annonce
    Route::get('passerelles','ArticleController@passerelles')->name('passerelles.index');

    // Etat financier
    Route::get('/etat-financier/{date_deb?}/{date_fin?}', 'FactureController@etat_financier')->name('etat_financier');       


    // Outil de calcul
    Route::get('outil-calcul/', 'OutilcalculController@index')->name('outil_calcul.index');       
    Route::post('outil-calcul/ca', 'OutilcalculController@ca')->name('outil_calcul.ca');       
    Route::post('outil-calcul/ca-styl', 'OutilcalculController@ca_styl')->name('outil_calcul.ca_styl');       



    // ##### CALCUL STATS 
    Route::get('stats/{annee}','StatController@index')->name('stats.index');
    
    
    
    // Test
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
  
    
    // historique
    Route::get('/historiques', 'HistoriqueController@index')->name('historique.index');       
    Route::get('/historique/connexions', 'HistoriqueController@connexions')->name('historique.connexions');       


    // Se connecter sur une autre session utilisateur

    Route::get('/switch/{user_id}','MandataireController@switch_user')->name('switch_user')->middleware('admin');
    Route::get('/unswitch','MandataireController@unswitch_user')->name('unswitch_user');


// #######Système de notifications

    Route::get('/notifications','NotificationController@index')->name('notifications.index');
    Route::get('/notifications/delete/{id?}','NotificationController@delete')->name('notification.delete');
    





    // Agenda  général
    Route::get('/agendas/general','AgendaController@index')->name('agendas.index');
    Route::get('/agendas/general/listing','AgendaController@listing')->name('agendas.listing');
    Route::get('/agendas/general/listing-a-faire','AgendaController@listing_a_faire')->name('agendas.listing_a_faire');
    Route::get('/agendas/general/listing-en-retard','AgendaController@listing_en_retard')->name('agendas.listing_en_retard');
    Route::post('/agenda/store','AgendaController@store')->name('agenda.store');
    Route::post('/agenda/update','AgendaController@update')->name('agenda.update');
    Route::get('/agenda/delete/{agenda_id}','AgendaController@destroy')->name('agenda.delete');


    // Export WINFIC liste des factures ventes
    Route::get('/winfic','ExportwinficController@index')->name('winfic.index');

    // Export WINFIC liste des factures fournisseurs
    Route::get('/winfic/fournisseur','ExportwinficController@index_fournisseur')->name('winfic.index_fournisseur');

    // tranfert des ventes
    Route::get('/winfic/exporter_ecriture1/{date_deb?}/{date_fin?}','ExportwinficController@exporter_ecriture1')->name('winfic.exporter_ecriture1');
    // Transfert des encaissements et decaissements
    Route::get('/winfic/exporter_ecriture2/{date_deb?}/{date_fin?}','ExportwinficController@exporter_ecriture2')->name('winfic.exporter_ecriture2');

    // Transfert des factures fournisseurs (Achats) 
    Route::post('/winfic/exporter_ecriture3/{date_deb?}/{date_fin?}','ExportwinficController@exporter_ecriture3')->name('winfic.exporter_ecriture3');

    Route::get('/winfic/exporter_ecrana/{date_deb?}/{date_fin?}','ExportwinficController@exporter_ecrana')->name('winfic.exporter_ecrana');
    Route::get('/winfic/code-analytic-client','ExportwinficController@code_analytic_client')->name('winfic.code_analytic_client');
    Route::get('/winfic/download/{fichier?}','ExportwinficController@download_export')->name('winfic.download_export');

    Route::get('/merge_facture/{date_deb?}/{date_fin?}','ExportwinficController@merge_factures')->name('merge_facture');
    Route::post('/merge_facture_fournisseur/{date_deb?}/{date_fin?}','ExportwinficController@merge_factures_fournisseur')->name('merge_facture_fournisseur');



    // Banque

    Route::get('/banque/traitement','BanqueController@traiter_encaissement')->name('banque.traitement');
    Route::get('/banque/lecture_fichier','BanqueController@lecture_fichier_banque')->name('banque.lecture.fichier');


    // Documents

    Route::get('/documents','DocumentController@index')->name('document.index')->middleware('admin');
    Route::get('/documents/a_valider','DocumentController@a_valider')->name('document.a_valider')->middleware('admin');
    Route::get('/documents/valider/{validation}/{fichier_id}','DocumentController@valider')->name('document.valider')->middleware('admin');
    Route::get('/documents/liste','DocumentController@liste')->name('document.liste');
    Route::get('/documents/create','DocumentController@create')->name('document.create')->middleware('admin');
    Route::get('/documents/edit/{document_id}','DocumentController@edit')->name('document.edit')->middleware('admin');
    Route::get('/documents/show/{mandataire_id}','DocumentController@show')->name('document.show');
    Route::post('/documents/store','DocumentController@store')->name('document.store');
    Route::post('/documents/update/{document_id}','DocumentController@update')->name('document.update');
    Route::get('/documents/archiver/{document_id}','DocumentController@archiver')->name('document.archiver');
    Route::post('/documents/save_doc/{mandataire_id}','DocumentController@save_doc')->name('document.save_doc');
    Route::get('/documents/telecharger/{mandataire_id}/{document_id}','DocumentController@download_document')->name('document.telecharger');
    Route::get('/documents/telecharger_historique/{historique_id}/','DocumentController@download_historique_document')->name('document.telecharger.historique');
    Route::get('/documents/historique/{mandataire_id}','DocumentController@historique')->name('document.historique');


    // Blibliotheque
    Route::get('/bibliotheque','BibliothequeController@index')->name('bibliotheque.index');
    Route::get('/bibliotheque/create','BibliothequeController@create')->name('bibliotheque.create');
    Route::get('/bibliotheque/edit/{bibliotheque_id}','BibliothequeController@edit')->name('bibliotheque.edit');
    Route::post('/bibliotheque/store','BibliothequeController@store')->name('bibliotheque.store');
    Route::post('/bibliotheque/update/{bibliotheque_id}','BibliothequeController@update')->name('bibliotheque.update');
    Route::get('/bibliotheque/telecharger/{bibliotheque_id}','BibliothequeController@download_bibliotheque')->name('bibliotheque.telecharger');
    Route::get('/bibliotheque/delete/{bibliotheque_id}','BibliothequeController@destroy')->name('bibliotheque.delete');
    Route::get('/bibliotheque/envoyer/{bibliotheque_id}/{user_id}/{type?}','BibliothequeController@envoyer_document')->name('bibliotheque.envoyer');


    // Outils informatique
    Route::get('/outil-info','OutilinfoController@index')->name('outil_info.index');
    Route::get('/outil-info/create','OutilinfoController@create')->name('outil_info.create');
    Route::get('/outil-info/edit/{outil_id}','OutilinfoController@edit')->name('outil_info.edit');
    Route::post('/outil-info/store','OutilinfoController@store')->name('outil_info.store');
    Route::post('/outil-info/update/{outil_id}','OutilinfoController@update')->name('outil_info.update');

    Route::get('/outil-info/archive','OutilinfoController@archive')->name('outil_info.archive');
    Route::delete('/outil-info/delete/{outil_id}','OutilinfoController@delete')->name('outil_info.delete');

    // Fiche informatique
    Route::get('/fiche-info','FicheinfoController@index')->name('fiche_info.index');
    Route::get('/fiche-info/create/{mandataire_id}','FicheinfoController@create')->name('fiche_info.create');
    Route::get('/fiche-info/edit/{mandataire_id}','FicheinfoController@edit')->name('fiche_info.edit');
    Route::post('/fiche-info/store','FicheinfoController@store')->name('fiche_info.store');
    Route::post('/fiche-info/update/{mandataire_id}','FicheinfoController@update')->name('fiche_info.update');
    Route::get('/fiche-info/pdf/{mandataire_id}','FicheinfoController@fiche_pdf')->name('fiche_info.fiche_pdf');
    Route::get('/fiche-info/reiniatiliser/{mandataire_id}','FicheinfoController@reiniatiliser')->name('fiche_info.reiniatiliser');

    // Gestion des mandats
    Route::get('/mandats','MandatController@index')->name('mandat.index');
    Route::get('/mandats/create','MandatController@create')->name('mandat.create');
    Route::post('/mandats/store','MandatController@store')->name('mandat.store');
    Route::get('/mandats/edit/{mandat_id}','MandatController@edit')->name('mandat.edit');
    Route::get('/mandats/completer/{mandat_id}','MandatController@completer')->name('mandat.completer');
    Route::get('/mandats/show/{mandat_id}','MandatController@show')->name('mandat.show');
    Route::post('/mandats/update/{id}', 'MandatController@update')->name('mandat.update');
    Route::post('/mandats/reserver', 'MandatController@reserver')->name('mandat.reserver');
    Route::post('/mandats/store-reservation', 'MandatController@store_reservation')->name('mandat.store_reservation');
    Route::post('/mandats/update-reservation/{mandat}', 'MandatController@update_reservation')->name('mandat.update_reservation');
    Route::get('/mandats/contacts', 'MandatController@getContacts')->name('contacts.list');
    Route::post('/mandats/cloturer/{id}', 'MandatController@cloturer')->name('mandat.cloturer');
    // Route::post('/mandats/archiver/{id}', 'MandatController@archiver')->name('mandat.archiver');
    // Route::post('/mandats/desarchiver/{id}', 'MandatController@desarchiver')->name('mandat.desarchiver');

    // Ajouter cette route avant la route create
    Route::get('/mandats/select-type', 'MandatController@selectType')->name('mandat.select_type');

    // Ajouter dans le groupe middleware auth
    Route::get('/mandats/parametres', 'MandatController@parametres')->name('mandat.parametres');
    Route::post('/mandats/update-parametres/{user}', 'MandatController@updateParametres')->name('mandat.update_parametres');

    // Ajouter ces routes dans le groupe middleware auth
    Route::get('/mandats/mandataires', 'MandatController@getMandataires')->name('mandat.mandataires');
    Route::get('/mandats/types', 'MandatController@getTypes')->name('mandat.types');

    // Ajouter dans le groupe middleware auth
    Route::get('/mandats/filter', 'MandatController@getMandatsByFilter')->name('mandat.filter');

    // Ajouter dans le groupe middleware auth
    Route::post('/mandats/restaurer/{id}', 'MandatController@restaurer')->name('mandat.restaurer');

    // Ajouter dans le groupe middleware auth
    Route::get('/mandats/statistiques', 'MandatController@statistiques')->name('mandat.statistiques');

    // Ajouter dans le groupe middleware auth
    Route::get('/mandats/import', 'MandatController@import')->name('mandat.import')->middleware('admin');
    Route::post('/mandats/process-import', 'MandatController@processImport')->name('mandat.process_import')->middleware('admin');

    // Ajouter cette route
    Route::get('/mandats/info/{numero}', 'MandatController@getMandatInfo')->name('mandat.info');

    // Ajouter cette route
    Route::get('/mandats/for-compromis', 'MandatController@getMandatsForCompromis')->name('mandats.for-compromis');

});

    // Blibliotheque
Route::get('/bibliotheque/show/{bibliotheque_id}/{user_id}/{type_user}','BibliothequeController@show')->name('bibliotheque.show');
Route::post('/bibliotheque/reponseuser/{bibliotheque_id}/{user_id}/{type?}','BibliothequeController@reponseUser')->name('bibliotheque.reponseuser');


// Envoi de la fiche info au prospect
Route::get('fiche/prospect/{prospect}/','ProspectController@create_fiche')->name('prospect.fiche');
Route::post('fiche/prospect/{prospect}/','ProspectController@sauvegarder_fiche')->name('prospect.sauvegarder_fiche');





// Tests
Route::get('test','TvaController@test')->name('test');

// Route::get('/test', function () {
//     return view('test');
// });

// Ajouter ces routes en dehors du groupe middleware auth
Route::get('/reservation-externe', 'MandatController@reservationExterne')->name('reservation.externe');
Route::post('/check-code', 'MandatController@checkCode')->name('check.code');
Route::post('/reserver-externe', 'MandatController@reserverExterne')->name('reserver.externe');

Route::post('/mandats/update-reservation-externe/{id}', 'MandatController@updateReservationExterne')->name('update.reservation.externe');

Route::post('/mandats/process-import-retour', 'MandatController@processImportRetour')->name('mandat.process_import_retour')->middleware('admin');
