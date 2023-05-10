<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Response;
use Intervention\Image\Facades\Image;
use Illuminate\Contracts\Encryption\DecryptException;

use App\User;
use App\Bien;
use App\Biencomposition;
use App\Biendetail;
use App\Bienphoto;
use App\Contact;
use App\Individu;
use App\Entite;
use App\Mandat;
use Auth;

use App\Models\Passerelles;
use Illuminate\Support\Facades\Crypt;
use PDF;
use SoapBox\Formatter\Formatter;

class BienController extends Controller
{
        //
        private $photos_path;

        public function __construct()
        {
           $this->photos_path = public_path('/images/photos_bien');
        }
    
    /**  
     * Liste des biens 
     * 
     * @author jean-philippe
     * @return \Illuminate\Http\Response
    **/ 
        public function index(){
    
            $biens = Bien::where('user_id',auth()->id())->get();
            // dd($biens);
            return view('bien.index',compact('biens'));
        }
    
    /**  
     * Créer un bien 
     * 
     * @author jean-philippe
     * @return \Illuminate\Http\Response
    **/ 
        public function create(){
            // $user = User::find(1)->get();
            $contacts = Contact::where([['user_id', Auth::user()->id], ['archive', false]])->get();

            return view('bien.add',compact('contacts'));
        }
    
    /**   
     * liste des champs du bien 
     * 
     * @author jean-philippe
    **/ 
    public function up(){
    
    
    
    }
    
    /**   
     * Enregistrement d'un bien
     * 
     * @author jean-philippe
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    **/ 
        public function store(Request $request){
            

    
    
            $bien = Bien::create([
                "type_offre"=> $request['type_offre'],
                "type_bien"=> $request['type_bien'],
                "user_id"=> auth()->id(),
            ]);
    
    
    
    
    
    // Création du Propriétaire 
    
    if($request->ajouter_proprietaire != null){
        
        $contact = Contact::create([
            "user_id" => Auth::user()->id,
            "nature" => $request->nature_proprietaire,
            "type" => $request->type,           
            "est_proprietaire" => true,         
            "note" => $request->note_proprietaire,
                     
        ]);
                 
    
        if($request->type == "individu"){
        
            $individu = Individu::create([
                "user_id"=> Auth::user()->id,     
                "contact_id" => $contact->id,
                
                "civilite" => $request->civilite_proprietaire,
                "nom" => $request->nom_proprietaire,
                "prenom" => $request->prenom_proprietaire,
                "adresse" => $request->adresse_proprietaire,
                "code_postal" => $request->code_postal_proprietaire,
                "ville" => $request->ville_proprietaire,
                "telephone_fixe" => $request->telephone_fixe_proprietaire,
                "telephone_mobile" => $request->telephone_mobile_proprietaire,
                "email" => $request->email_proprietaire,
                
                "civilite1" => $request->civilite1_proprietaire,
                "nom1" => $request->nom1_proprietaire,
                "prenom1" => $request->prenom1_proprietaire,
                "adresse1" => $request->adresse1_proprietaire,
                "code_postal1" => $request->code_postal1_proprietaire,
                "ville1" => $request->ville1_proprietaire,
                "telephone_fixe1" => $request->telephone_fixe1_proprietaire,
                "telephone_mobile1" => $request->telephone_mobile1_proprietaire,
                "email1" => $request->email1_proprietaire,
                
                "civilite2" => $request->civilite2_proprietaire,
                "nom2" => $request->nom2_proprietaire,
                "prenom2" => $request->prenom2_proprietaire,
                "adresse2" => $request->adresse2_proprietaire,
                "code_postal2" => $request->code_postal2_proprietaire,
                "ville2" => $request->ville2_proprietaire,
                "telephone_fixe2" => $request->telephone_fixe2_proprietaire,
                "telephone_mobile2" => $request->telephone_mobile2_proprietaire,
                "email2" => $request->email2_proprietaire,                
             
            ]);
            
        }else{
            
            $entite = Entite::create([
                "user_id"=> Auth::user()->id,                
                "contact_id" => $contact->id,
                "forme_juridique" => $request->forme_juridique_proprietaire,
                "nom" => $request->nom_groupe_proprietaire,
                "raison_sociale" => $request->raison_sociale_proprietaire,
                "type" => $request->type_groupe_proprietaire,
                "adresse" => $request->adresse_proprietaire,
                "code_postal" => $request->code_postal_proprietaire,
                "ville" => $request->ville_proprietaire,
                "telephone_fixe" => $request->telephone_fixe_proprietaire,
                "telephone_mobile" => $request->telephone_mobile_proprietaire,
                "email" => $request->email_proprietaire,
                "numero_siret" => $request->numero_siret_proprietaire,
                "code_naf" => $request->code_naf_proprietaire,
                "date_immatriculation" => $request->date_immatriculation_proprietaire,
                "numero_rsac" => $request->numero_rsac_proprietaire,
                "numero_assurance" => $request->numero_assurance_proprietaire,
                "numero_tva" => $request->numero_tva_proprietaire,
                "numero_rcs" => $request->numero_rcs_proprietaire,
                            
             
            ]);
        }
    
    }else{
    
        $contact = Contact::where('id', $request->proprietaire_id)->first();
    }
    
    $bien->proprietaire_id = $contact->id;

   
    
    // Création du mandat
            $mandat = Mandat::create([
                "user_id" => Auth::user()->id,
                "bien_id" => $bien->id,
                // Le contact ici c'est le propriétaire du bien
                "proprietaire_id" => $contact->id,
                // exclusif', 'semi-exclusif','simple'
                "type" => $request->type_mandat,
                "numero" => $request->numero_mandat,
                "date_debut" => $request->date_debut_mandat,
                "date_fin" => $request->date_fin_mandat,
                "duree_irrevocabilite" => $request->duree_irrevocabilite_mandat,
                "note" => $request->note_mandat,
            ]);
    
    
    
    
    
            $biendetail = Biendetail::create([
                "bien_id" => $bien->id,
            ]);
   

            
    
            if($request['type_offre'] == "vente"){         // Vente
    
                if($request['type_bien'] == "maison"){
    
                    $bien->type_type_bien = $request['type_maison_vente_maison'];
                    $bien->titre_annonce = $request['titre_annonce_vente_maison'];
                    $bien->description_annonce = $request['description_annonce_vente_maison'];                
                    $bien->surface_habitable = $request['surface_habitable_vente_maison'];
                    $bien->surface_terrain = $request['surface_terrain_vente_maison']; // maison
                    $bien->nombre_piece = $request['nb_piece_vente_maison'];
                    $bien->nombre_chambre = $request['nb_chambres_vente_maison'];
                    $bien->nombre_niveau = $request['nombre_niveau_vente_maison'];
    
                    $bien->jardin = $request['jardin_vente_maison'];// maison
                    $bien->jardin_surface = $request['surface_jardin_vente_maison'];// maison
                    $bien->jardin_privatif = $request['privatif_jardin_vente_maison'];// maison
                    $bien->jardin_volume = $request['volume_piscine_vente_maison'];// maison
                    $bien->piscine = $request['piscine_vente_maison'];// maison
                    $bien->piscine_statut = $request['statut_piscine_vente_maison'];// maison
                    $bien->piscine_nature = $request['nature_piscine_vente_maison'];// maison                
                    $bien->jardin_pool_house = $request['pool_house_piscine_vente_maison'];// maison
                    $bien->jardin_chauffee = $request['chauffee_piscine_vente_maison'];// maison
                    $bien->jardin_couverte = $request['couverte_piscine_vente_maison'];// maison
    
                    $bien->pays = $request['pays_vente_maison'];
                    $bien->ville = $request['ville_vente_maison'];
                    $bien->code_postal = $request['code_postal_vente_maison'];
                    // $bien->numero_dossier = $request['numero_dossier_vente_maison'];
                    // $bien->date_creation_dossier = $request['date_creation_dossier_vente_maison'];
                    $bien->nombre_garage = $request['nb_garage_vente_maison'];
                    $bien->exposition_situation = $request['exposition_situation_vente_maison'];
                    $bien->vue_situation = $request['vue_situation_vente_maison'];                
                    
                }
                elseif($request['type_bien'] == "appartement"){
                   
                    $bien->type_type_bien = $request['type_appartement_vente_appart'];
                    $bien->titre_annonce = $request['titre_annonce_vente_appart'];
                    $bien->description_annonce = $request['description_annonce_vente_appart'];                
                    $bien->surface_habitable = $request['surface_habitable_vente_appart'];
                    $bien->nombre_piece = $request['nb_piece_vente_appart'];
                    $bien->nombre_chambre = $request['nb_chambres_vente_appart'];
                    $bien->nombre_niveau = $request['nombre_niveau_vente_appart'];
                    $bien->pays = $request['pays_vente_appart'];
                    $bien->ville = $request['ville_vente_appart'];
                    $bien->code_postal = $request['code_postal_vente_appart'];
                    // $bien->numero_dossier = $request['numero_dossier_vente_appart'];
                    // $bien->date_creation_dossier = $request['date_creation_dossier_vente_appart'];
                    $bien->nombre_garage = $request['nb_garage_vente_appart'];
                    $bien->exposition_situation = $request['exposition_situation_vente_appart'];
                    $bien->vue_situation = $request['vue_situation_vente_appart'];
    
                }
                elseif($request['type_bien'] == "terrain"){
    
                    $bien->type_type_bien = "Terrain";
                    $bien->titre_annonce = $request['titre_annonce_vente_terrain'];
                    $bien->description_annonce = $request['description_annonce_vente_terrain'];
                    $bien->surface_habitable = $request['surface_habitable_vente_terrain'];
                    $bien->pays = $request['pays_vente_terrain'];
                    $bien->ville = $request['ville_vente_terrain'];
                    $bien->code_postal = $request['code_postal_vente_terrain'];
                    // $bien->numero_dossier = $request['numero_dossier_vente_terrain'];
                    // $bien->date_creation_dossier = $request['date_creation_dossier_vente_terrain'];
    
                }
                elseif($request['type_bien'] == "autreType"){
    
                    $bien->type_type_bien = $request['type_appartement_vente_autreType'];
                    $bien->titre_annonce = $request['titre_annonce_vente_autreType'];
                    $bien->description_annonce = $request['description_annonce_vente_autreType'];
                    $bien->surface = $request['surface_vente_autreType'];
                    $bien->surface_habitable = $request['surface_habitable_vente_autreType'];
                    $bien->nombre_piece = $request['nb_piece_vente_autreType'];
                    $bien->nombre_chambre = $request['nb_chambres_vente_autreType'];
                    $bien->nombre_niveau = $request['nombre_niveau_vente_autreType'];
                    $bien->jardin = $request['jardin_vente_autreType'];
                    $bien->jardin_surface = $request['surface_jardin_vente_autreType'];
                    $bien->jardin_privatif = $request['privatif_jardin_vente_autreType'];
                    $bien->surface_terrain = $request['surface_terrain_vente_autreType'];
                    $bien->piscine = $request['piscine_vente_autreType'];
                    $bien->piscine_statut = $request['statut_piscine_vente_autreType'];
                    $bien->piscine_nature = $request['nature_piscine_vente_autreType'];
                    $bien->jardin_volume = $request['volume_piscine_vente_autreType'];
                    $bien->jardin_pool_house = $request['pool_house_piscine_vente_autreType'];
                    $bien->jardin_chauffee = $request['chauffee_piscine_vente_autreType'];
                    $bien->jardin_couverte = $request['couverte_piscine_vente_autreType'];
                    $bien->pays = $request['pays_vente_autreType'];
                    $bien->ville = $request['ville_vente_autreType'];
                    $bien->code_postal = $request['code_postal_vente_autreType'];
                    // $bien->numero_dossier = $request['numero_dossier_vente_autreType'];
                    // $bien->date_creation_dossier = $request['date_creation_dossier_vente_autreType'];
                    $bien->nombre_garage = $request['nb_garage_vente_autreType'];
                    $bien->exposition_situation = $request['exposition_situation_vente_autreType'];
                    $bien->vue_situation = $request['vue_situation_vente_autreType'];
    
                }
                else{
    
                }
               
            }else{ // Location
                
                if($request['type_bien'] == "maison"){
    
                    $bien->type_type_bien = $request['type_maison_location_maison'];
                    $bien->titre_annonce = $request['titre_annonce_location_maison'];
                    $bien->description_annonce = $request['description_annonce_location_maison'];
                    $bien->duree_bail = $request['duree_bail_location_maison'];
                    $bien->surface_habitable = $request['surface_habitable_location_maison'];
                    $bien->nombre_piece = $request['nb_piece_location_maison'];
                    $bien->nombre_chambre = $request['nb_chambres_location_maison'];
                    $bien->nombre_niveau = $request['nombre_niveau_location_maison'];
                    $bien->jardin = $request['jardin_location_maison'];
                    $bien->jardin_surface = $request['surface_jardin_location_maison'];
                    $bien->jardin_privatif = $request['privatif_jardin_location_maison'];
                    $bien->surface_terrain = $request['surface_terrain_location_maison'];
                    $bien->piscine = $request['piscine_location_maison'];
                    $bien->piscine_statut = $request['statut_piscine_location_maison'];
                    $bien->piscine_nature = $request['nature_piscine_location_maison'];
                    $bien->jardin_volume = $request['volume_piscine_location_maison'];
                    $bien->jardin_pool_house = $request['pool_house_piscine_location_maison'];
                    $bien->jardin_chauffee = $request['chauffee_piscine_location_maison'];
                    $bien->jardin_couverte = $request['couverte_piscine_location_maison'];                
                    $bien->pays = $request['pays_location_maison'];
                    $bien->ville = $request['ville_location_maison'];
                    $bien->code_postal = $request['code_postal_location_maison'];
                    // $bien->numero_dossier = $request['numero_dossier_location_maison'];
                    // $bien->date_creation_dossier = $request['date_creation_dossier_location_maison'];
                    $bien->meuble = $request['meuble_location_maison'];
                    $bien->nombre_garage = $request['nb_garage_location_maison'];
                    $bien->exposition_situation = $request['exposition_situation_location_maison'];
                    $bien->vue_situation = $request['vue_situation_location_maison'];
    
                    
                    
                }
                elseif($request['type_bien'] == "appartement"){
    
                    $bien->type_type_bien = $request['type_appartement_location_appart'];
                    $bien->titre_annonce = $request['titre_annonce_location_appart'];
                    $bien->description_annonce = $request['description_annonce_location_appart'];
                    $bien->duree_bail = $request['duree_bail_location_appart'];              
                    $bien->surface_habitable = $request['surface_habitable_location_appart'];
                    $bien->nombre_piece = $request['nb_piece_location_appart'];
                    $bien->nombre_chambre = $request['nb_chambres_location_appart'];
                    $bien->nombre_niveau = $request['nombre_niveau_location_appart'];
                    $bien->pays = $request['pays_location_appart'];
                    $bien->ville = $request['ville_location_appart'];
                    $bien->code_postal = $request['code_postal_location_appart'];
                    // $bien->numero_dossier = $request['numero_dossier_location_appart'];
                    // $bien->date_creation_dossier = $request['date_creation_dossier_location_appart'];
                    $bien->meuble = $request['meuble_location_appart'];
                    $bien->nombre_garage = $request['nb_garage_location_appart'];
                    $bien->exposition_situation = $request['exposition_situation_location_appart'];
                    $bien->vue_situation = $request['vue_situation_location_appart'];
                    
                }elseif($request['type_bien'] == "terrain"){
     
                    $bien->titre_annonce = $request['titre_annonce_location_terrain'];
                    $bien->description_annonce = $request['description_annonce_location_terrain'];
                    $bien->duree_bail = $request['duree_bail_location_terrain'];
                    $bien->surface_habitable = $request['surface_habitable_location_terrain'];
                    $bien->pays = $request['pays_location_terrain'];
                    $bien->ville = $request['ville_location_terrain'];
                    $bien->code_postal = $request['code_postal_location_terrain'];
                    // $bien->numero_dossier = $request['numero_dossier_location_terrain'];
                    // $bien->date_creation_dossier = $request['date_creation_dossier_location_terrain'];
    
                }elseif($request['type_bien'] == "autreType"){
                    $bien->type_type_bien = $request['type_appartement_location_autreType'];
                    $bien->titre_annonce = $request['titre_annonce_location_autreType'];
                    $bien->description_annonce = $request['description_annonce_location_autreType'];
                    $bien->duree_bail = $request['duree_bail_location_autreType'];
                    $bien->surface = $request['surface_location_autreType'];
                    $bien->surface_habitable = $request['surface_habitable_location_autreType'];
                    $bien->nombre_piece = $request['nb_piece_location_autreType'];
                    $bien->nombre_chambre = $request['nb_chambres_location_autreType'];
                    $bien->nombre_niveau = $request['nombre_niveau_location_autreType'];
                    $bien->jardin = $request['jardin_location_autreType'];
                    $bien->jardin_surface = $request['surface_jardin_location_autreType'];
                    $bien->jardin_privatif = $request['privatif_jardin_location_autreType'];
                    $bien->terrain_surface = $request['surface_terrain_location_autreType'];
                    $bien->piscine = $request['piscine_location_autreType'];
                    $bien->piscine_statut = $request['statut_piscine_location_autreType'];
                    $bien->piscine_nature = $request['nature_piscine_location_autreType'];
                    $bien->jardin_volume = $request['volume_piscine_location_autreType'];
                    $bien->jardin_pool_house = $request['pool_house_piscine_location_autreType'];
                    $bien->jardin_chauffee = $request['chauffee_piscine_location_autreType'];
                    $bien->jardin_couverte = $request['couverte_piscine_location_autreType'];
                    $bien->pays = $request['pays_location_autreType'];
                    $bien->ville = $request['ville_location_autreType'];
                    $bien->code_postal = $request['code_postal_location_autreType'];
                    // $bien->numero_dossier = $request['numero_dossier_location_autreType'];
                    // $bien->date_creation_dossier = $request['date_creation_dossier_location_autreType'];
                    $bien->meuble = $request['meuble_location_autreType'];
                    $bien->nombre_garage = $request['nb_garage_location_autreType'];
                    $bien->exposition_situation = $request['exposition_situation_location_autreType'];
                    $bien->vue_situation = $request['vue_situation_location_autreType'];
                    
    
                }
                else{
    
                }
    
    
            }
                   
            $bien->titre_annonce_vitrine = $bien->titre_annonce ;
            $bien->description_annonce_vitrine = $bien->description_annonce ;
            $bien->titre_annonce_privee =  $bien->titre_annonce ;
            $bien->description_annonce_privee = $bien->description_annonce ;            
    
            // secteur
            // à revoir serialiser les donnees
    
            $section_parcelle = array(array());
            if($request['section_secteurs'] != null){
                 for ($i=0 ; $i < sizeof($request['section_secteurs']) ; $i++) {
                    $section_parcelle[$i][0] = $request['section_secteurs'][$i] ;
                    $section_parcelle[$i][1] = $request['parcelle_secteurs'][$i] ;
                }
                $bien->section_parcelle = serialize($section_parcelle);
            }
           
            // fin
    
            $bien->pays_annonce = $request['pays_annonce_secteur'];
            $bien->adresse_bien = $request['adresse_bien_secteur'];
            $bien->complement_adresse = $request['complement_adresse_secteur'];
            $bien->quartier = $request['quartier_secteur'];
            $bien->secteur = $request['secteur_secteur'];
            $bien->immeuble_batiment = $request['immeuble_batiment_secteur'];
            $bien->transport_a_proximite = $request['transport_a_proximite_secteur'];
            $bien->proximite = $request['proximite_secteur'];
            $bien->environnement = $request['environnement_secteur'];
            
         
            //composition   à sérialiser          
            $composition_piece = array(array());
            if(isset($request['piece_compositions'])){
    
                for ($i=0 ; $i < sizeof($request['piece_compositions'] ); $i++) {
                    
                    Biencomposition::create([
                        "bien_id" => $bien->id,
                        "piece" => $request['piece_compositions'][$i],
                        "detail" => $request['detail_piece_compositions'][$i],
                        "surface" => $request['surface_compositions'][$i],
                        "note" => $request['note_compositions'][$i],
                        "est_privee" => $request['note_privee_compositions'][$i],
                        "est_publique" => $request['note_publique_compositions'][$i],
                        "est_inter_agence" => $request['note_inter_agence_compositions'][$i],
                        "nombre_etage" => $request['etage_compositions'][$i],
                    ]);
     
                }
              
            }
            
            //fin
            
            // Prix
            $bien->prix_public = $request['prix_public_info_fin'];
            $bien->prix_prive = $request['prix_net_info_fin'];        
            $bien->honoraire_acquereur = $request['honoraire_acquereur_info_fin'];
            $bien->part_acquereur = $request['part_acquereur_info_fin'];
            $bien->taux_prix = $request['taux_prix_info_fin'];
            $bien->honoraire_vendeur = $request['honoraire_vendeur_info_fin'];
            $bien->part_vendeur = $request['part_vendeur_info_fin'];
            $bien->taux_net = $request['taux_net_info_fin'];
            $bien->complement_loyer = $request['complement_loyer'];
            $bien->loyer = $request['loyer'];
            $bien->estimation_date = $request['estimation_date_info_fin'];
            $bien->viager_prix_bouquet = $request['viager_valeur_info_fin'];
            $bien->viager_rente_mensuelle = $request['viager_rente_mensuelle_info_fin'];
            $bien->estimation_valeur = $request['estimation_valeur_info_fin'];
            $bien->travaux_a_prevoir = $request['travaux_a_prevoir_info_fin'];
            $bien->depot_garanti = $request['depot_garanti_info_fin'];
            $bien->taxe_habitation = $request['taxe_habitation_info_fin'];
            $bien->taxe_fonciere = $request['taxe_fonciere_info_fin'];
            $bien->charge_mensuelle_total = $request['charge_mensuelle_total_info_fin'];
            $bien->charge_mensuelle_info = $request['charge_mensuelle_info_info_fin'];
     
             //fin
    
          //détails
            $biendetail->particularite_particularite = $request['particularite_particularite'];
            $biendetail->agen_inter_nb_chambre = $request['nb_chambre_agencement_interieur'];
            $biendetail->agen_inter_nb_salle_bain = $request['nb_salle_bain_agencement_interieur'];
            $biendetail->agen_inter_nb_salle_eau = $request['nb_salle_eau_agencement_interieur'];
            $biendetail->agen_inter_nb_wc = $request['nb_wc_agencement_interieur'];
            $biendetail->agen_inter_nb_lot = $request['nb_lot_agencement_interieur'];
            $biendetail->agen_inter_nb_couchage = $request['nb_couchage_agencement_interieur'];
            $biendetail->agen_inter_nb_niveau = $request['nb_niveau_agencement_interieur'];
            $biendetail->agen_inter_grenier_comble = $request['grenier_comble_agencement_interieur'];
            $biendetail->agen_inter_buanderie = $request['buanderie_agencement_interieur'];
            $biendetail->agen_inter_meuble = $request['meuble_agencement_interieur'];
            $biendetail->agen_inter_surface_carrez = $request['surface_carrez_agencement_interieur'];
            $biendetail->agen_inter_surface_habitable = $request['surface_habitable_agencement_interieur'];
            $biendetail->agen_inter_surface_sejour = $request['surface_sejour_agencement_interieur'];
            $biendetail->agen_inter_cuisine_type = $request['cuisine_type_agencement_interieur'];
            $biendetail->agen_inter_cuisine_etat = $request['cuisine_etat_agencement_interieur'];
            $biendetail->agen_inter_situation_exposition = $request['situation_exposition_agencement_interieur'];
            $biendetail->agen_inter_situation_vue = $request['situation_vue_agencement_interieur'];               
            $biendetail->agen_exter_mitoyennete = $request['mitoyennete_agencement_exterieur'];
            $biendetail->agen_exter_etage = $request['etages_agencement_exterieur'];
            $biendetail->agen_exter_terrasse = $request['terrasse_agencement_exterieur'];
            $biendetail->agen_exter_nb_terrasse = $request['nombre_terrasse_agencement_exterieur'];
            $biendetail->agen_exter_surface_terrasse = $request['surface_terrasse_agencement_exterieur'];
            $biendetail->agen_exter_plain_pied = $request['plain_pied_agencement_exterieur'];
            $biendetail->agen_exter_sous_sol = $request['sous_sol_agencement_exterieur'];
            $biendetail->agen_exter_surface_jardin = $request['surface_jardin_agencement_exterieur'];
            $biendetail->agen_exter_privatif_jardin = $request['privatif_jardin_agencement_exterieur'];
            $biendetail->agen_exter_type_cave = $request['type_cave_agencement_exterieur'];
            $biendetail->agen_exter_surface_cave = $request['surface_cave_agencement_exterieur'];
            $biendetail->agen_exter_balcon = $request['balcon_agencement_exterieur'];
            $biendetail->agen_exter_nb_balcon = $request['nb_balcon_agencement_exterieur'];
            $biendetail->agen_exter_surface_balcon = $request['surface_balcon_agencement_exterieur'];
            $biendetail->agen_exter_loggia = $request['loggia_agencement_exterieur'];
            $biendetail->agen_exter_surface_loggia = $request['surface_loggia_agencement_exterieur'];
            $biendetail->agen_exter_veranda = $request['veranda_agencement_exterieur'];
            $biendetail->agen_exter_surface_veranda = $request['surface_veranda_agencement_exterieur'];
            $biendetail->agen_exter_nb_garage = $request['nombre_garage_agencement_exterieur'];
            $biendetail->agen_exter_surface_garage = $request['surface_garage_agencement_exterieur'];
            $biendetail->agen_exter_parking_interieur = $request['parking_interieur_agencement_exterieur'];
            $biendetail->agen_exter_parking_exterieur = $request['parking_exterieur_agencement_exterieur'];
            $biendetail->agen_exter_statut_piscine = $request['statut_piscine_agencement_exterieur'];
            $biendetail->agen_exter_dimension_piscine = $request['dimension_piscine_agencement_exterieur'];
            $biendetail->agen_exter_volume_piscine = $request['volume_piscine_agencement_exterieur'];  
    
            $biendetail->terrain_surface_terrain = $request['surface_terrain'];
            $biendetail->terrain_constructible = $request['constructible_terrain'];
            $biendetail->terrain_surface_constructible = $request['surface_constructible_terrain'];
            $biendetail->terrain_topographie = $request['topographie_terrain'];
            $biendetail->terrain_emprise_au_sol = $request['emprise_au_sol_terrain'];
            $biendetail->terrain_emprise_au_sol_residuelle = $request['emprise_au_sol_residuelle_terrain'];
            $biendetail->terrain_shon = $request['shon_terrain'];
            $biendetail->terrain_ces = $request['ces_terrain'];
            $biendetail->terrain_pos = $request['pos_terrain'];
            $biendetail->terrain_codification_plu = $request['codification_plu_terrain'];
            $biendetail->terrain_droit_de_passage = $request['droit_de_passage_terrain'];
            $biendetail->terrain_reference_cadastrale = $request['reference_cadastrale_terrain'];
            $biendetail->terrain_piscinable = $request['piscinable_terrain'];
            $biendetail->terrain_arbore = $request['arbore_terrain'];
            $biendetail->terrain_viabilise = $request['viabilise_terrain'];
            $biendetail->terrain_cloture = $request['cloture_terrain'];
            $biendetail->terrain_divisible = $request['divisible_terrain'];
            $biendetail->terrain_possiblite_egout = $request['possiblite_egout_terrain'];
            $biendetail->terrain_info_copopriete = $request['info_copopriete_terrain'];
            $biendetail->terrain_acces = $request['acces_terrain'];
            $biendetail->terrain_raccordement_eau = $request['raccordement_eau_terrain'];
            $biendetail->terrain_raccordement_gaz = $request['raccordement_gaz_terrain'];
            $biendetail->terrain_raccordement_electricite = $request['raccordement_electricite_terrain'];
            $biendetail->terrain_raccordement_telephone = $request['raccordement_telephone_terrain'];
           
            $biendetail->equipement_format = $request['format_equipement'];
            $biendetail->equipement_type = $request['type_equipement'];
            $biendetail->equipement_energie = $request['energie_equipement'];
            $biendetail->equipement_ascenseur = $request['ascenseur_equipement'];
            $biendetail->equipement_acces_handicape = $request['acces_handicape_equipement'];
            $biendetail->equipement_climatisation = $request['climatisation_equipement'];
            $biendetail->equipement_climatisation_specification = $request['climatisation_specification_equipement'];      
            $biendetail->equipement_eau_alimentation = $request['eau_alimentation_equipement'];
            $biendetail->equipement_eau_assainissement = $request['eau_assainissement_equipement'];
            $biendetail->equipement_eau_chaude_distribution = $request['eau_chaude_distribution_equipement'];
            $biendetail->equipement_eau_chaude_energie = $request['eau_chaude_energie_equipement'];
            $biendetail->equipement_cheminee = $request['cheminee_equipement'];
            $biendetail->equipement_arrosage = $request['arrosage_automatique_equipement'];
            $biendetail->equipement_barbecue = $request['barbecue_equipement'];
            $biendetail->equipement_tennis = $request['tennis_equipement'];
            $biendetail->equipement_local_a_velo = $request['local_a_velo_equipement'];
            $biendetail->equipement_volet_electrique = $request['volet_electrique_equipement'];
            $biendetail->equipement_gardien = $request['gardien_equipement'];
            $biendetail->equipement_double_vitrage = $request['double_vitrage_equipement'];
            $biendetail->equipement_triple_vitrage = $request['triple_vitrage_equipement'];
            $biendetail->equipement_cable = $request['cable_equipement'];
            $biendetail->equipement_securite_porte_blinde = $request['securite_porte_blinde_equipement'];
            $biendetail->equipement_securite_interphone = $request['securite_interphone_equipement'];
            $biendetail->equipement_securite_visiophone = $request['securite_visiophone_equipement'];
            $biendetail->equipement_securite_alarme = $request['securite_alarme_equipement'];
            $biendetail->equipement_securite_digicode = $request['securite_digicode_equipement'];
            $biendetail->equipement_securite_detecteur_de_fumee = $request['securite_detecteur_de_fumee_equipement'];
            $biendetail->equipement_portail_electrique = $request['portail_electrique_equipement'];
            $biendetail->equipement_cuisine_ete = $request['cuisine_ete_equipement'];
    
            $biendetail->diagnostic_annee_construction = $request['annee_construction_diagnostic'];
            $biendetail->diagnostic_dpe_bien_soumi = $request['dpe_bien_soumi_diagnostic'];
            $biendetail->diagnostic_dpe_vierge = $request['dpe_vierge_diagnostic'];
            $biendetail->diagnostic_dpe_consommation = $request['dpe_consommation_diagnostic'];
            $biendetail->diagnostic_dpe_ges = $request['dpe_ges_diagnostic'];
            $biendetail->diagnostic_dpe_date = $request['dpe_diagnostic'];
            $biendetail->diagnostic_etat_exterieur = $request['etat_exterieur_diagnostic'];
            $biendetail->diagnostic_etat_interieur = $request['etat_interieur_diagnostic'];
            $biendetail->diagnostic_surface_annexe = $request['surface_annexe_diagnostic'];
            $biendetail->diagnostic_etat_parasitaire = $request['etat_parasitaire_diagnostic'];
            $biendetail->diagnostic_etat_parasitaire_date = $request['etat_parasitaire_date_diagnostic'];
            $biendetail->diagnostic_etat_parasitaire_commentaire = $request['etat_parasitaire_commentaire_diagnostic'];
            $biendetail->diagnostic_amiante = $request['amiante_diagnostic'];
            $biendetail->diagnostic_amiante_date = $request['amiante_date_diagnostic'];
            $biendetail->diagnostic_amiante_commentaire = $request['amiante_commentaire_diagnostic'];
            $biendetail->diagnostic_electrique = $request['electrique_diagnostic'];
            $biendetail->diagnostic_electrique_date = $request['electrique_date_diagnostic'];
            $biendetail->diagnostic_electrique_commentaire = $request['electrique_commentaire_diagnostic'];
            $biendetail->diagnostic_loi_carrez = $request['loi_carrez_diagnostic'];
            $biendetail->diagnostic_loi_carrez_date = $request['loi_carrez_date_diagnostic'];
            $biendetail->diagnostic_loi_carrez_commentaire = $request['loi_carrez_commentaire_diagnostic'];
            $biendetail->diagnostic_risque_nat = $request['risque_nat_diagnostic'];
            $biendetail->diagnostic_risque_nat_date = $request['risque_nat_date_diagnostic'];
            $biendetail->diagnostic_risque_nat_commentaire = $request['risque_nat_commentaire_diagnostic'];
            $biendetail->diagnostic_plomb = $request['plomb_diagnostic'];
            $biendetail->diagnostic_plomb_date = $request['plomb_date_diagnostic'];
            $biendetail->diagnostic_plomb_commentaire = $request['plomb_commentaire_diagnostic'];
            $biendetail->diagnostic_gaz = $request['gaz_diagnostic'];
            $biendetail->diagnostic_gaz_date = $request['gaz_date_diagnostic'];
            $biendetail->diagnostic_gaz_commentaire = $request['gaz_commentaire_diagnostic'];
            $biendetail->diagnostic_assainissement = $request['assainissement_diagnostic'];
            $biendetail->diagnostic_assainissement_date = $request['assainissement_date_diagnostic'];
            $biendetail->diagnostic_assainissement_commentaire = $request['assainissement_commentaire_diagnostic'];
    
            $biendetail->copropriete_bien_en = $request['bien_en_copropriete'];
            $biendetail->copropriete_numero_lot = $request['numero_lot_info_copropriete'];
            $biendetail->copropriete_nombre_lot = $request['nombre_lot_info_copropriete'];
            $biendetail->copropriete_quote_part_charge = $request['quote_part_charge_info_copropriete'];
            $biendetail->copropriete_montant_fond_travaux = $request['montant_fond_travaux_info_copropriete'];
            $biendetail->copropriete_plan_sauvegarde = $request['plan_sauvegarde_info_copropriete'];
            $biendetail->copropriete_statut_syndic = $request['statut_syndic_info_copropriete'];
            $biendetail->dossier_dispo_numero = $request['numero_dossier_dispo'];
            $biendetail->dossier_dispo_dossier_cree_le = $request['dossier_cree_le_dossier_dispo'];
            $biendetail->dossier_dispo_disponibilite_immediate = $request['disponibilite_immediate_dossier_dispo'];
            $biendetail->dossier_dispo_disponible_le = $request['disponible_le_dossier_dispo'];
            $biendetail->dossier_dispo_liberation_le = $request['liberation_le_dossier_dispo'];
    
            $biendetail->update();
           
    
            
            $bien->contacts()->attach([$contact->id => ['role_contact' => "Propriétaire"]]);
    
            // Sauvegarde du bien
            $bien->update();
    
    
            $bien_id = Crypt::encrypt($bien->id); 
            
            return redirect()->route('uptof',$bien_id);
            // dd($request);
        }
    
    
    
    /**  Affichage d'un bien 
    *
    * @author jean-philippe
    * @param  int $id
    * @return \Illuminate\Http\Response
    **/ 
    public function show($id){
        try {
            $bien_id = Crypt::decrypt($id);
        } catch(DecryptException $e){
            abort(404);
        }
        $bien = Bien::where('id',$bien_id)->firstorfail();
        $bien_id_crypt = $id;
    
        $liste_photos = Bienphoto::where('bien_id',$bien_id)->orderBy('image_position','asc')->get();
        $contacts = Contact::where([['user_id', Auth::user()->id], ['archive', false]])->get();
       
        $proprietaire = $bien->proprietaire;
        
        return view("bien.show",compact(['bien','bien_id_crypt','liste_photos','contacts', 'proprietaire']));
    }
    
    
    
    
    
        ///////// ########## GESTION DES PHOTOS D'UN BIEN 
    
        // affichage du formulaire d'ajout des photos du bien
        public function uploadPhoto($bien_id){
        
            return view('bien.photo.add',compact('bien_id'));
        }
    
        // sauvegarde des photos du bien 
        public function savePhoto(Request $request,$visibilite, $bien_id){
        
            $photos = $request->file('file');
             
            
            
            if (!is_array($photos)) {
                $photos = [$photos];
            }
            
            if (!is_dir($this->photos_path)) {
                mkdir($this->photos_path, 0777);
                $this->photos_path .= '/'.auth()->id();
                mkdir($this->photos_path, 0777);
            }else{
                $this->photos_path .= '/'.auth()->id();
                if (!is_dir($this->photos_path)) {
    
                    mkdir($this->photos_path, 0777);
                }
            }
    
            
           
                for ($i = 0; $i < count($photos); $i++) {
                    $photo = $photos[$i];
                    $name = sha1(date('YmdHis') .str_random(30));
                    $save_name = auth()->id().'/'.$name. '.' .$photo->getClientOriginalExtension();
                    $resize_name = $name. str_random(2). '.' .$photo->getClientOriginalExtension();
                    
                    $img = Image::make($photo);
                    // ->resize(750, 550)
                    // ->save($this->photos_path .'/' .$resize_name);
                    // return "123";
        
                  
                    $photo->move($this->photos_path, $save_name);
                    
                    // $bienid = $bien_id;
                    $bienid = Crypt::decrypt($bien_id);
                    
                    // dans ce bloc, on réccupère la plus grande position enrégistrée et on l'incremente pour la position de l'image suivante
                    $image_position = 0;
                    $image_position =  Bienphoto::where([
                        ['bien_id',$bienid],
                        ['visibilite',$visibilite]
                        ])->pluck('image_position')->toArray();
    
                    if(sizeof($image_position) ==0){
                        $image_position = 1;
                    }else{
                          $image_position = max($image_position ) + 1;
                    }
                  
                    
    
                    Bienphoto::create([
                        "bien_id" => $bienid,
                        "visibilite"=> $visibilite,
                        "filename"=> $save_name,
                        "resized_name"=>auth()->id().'/'.$resize_name,
                        "original_name"=> basename($photo->getClientOriginalName()),
                        "image_position" => $image_position,
    
                    ]);
                         //dd($photos);
                }
            return Response::json([
                'message' => 'Image sauvegardée'
            ], 200);
        }
    
        
        // Suppression d'une photo pendant l'upload
        public function destroyPhoto(Request $request)
        {
            $filename = $request->id;
            $uploaded_image = Bienphoto::where('original_name', basename($filename))->first();
     
            if (empty($uploaded_image)) {
                return Response::json(['message' => 'desolé cette photo n\'existe pas'], 400);
            }
     
            $file_path = $this->photos_path . '/' . $uploaded_image->filename;
            $resized_file = $this->photos_path . '/' . $uploaded_image->resized_name;
     
            if (file_exists($file_path)) {
                unlink($file_path);
            }
     
            if (file_exists($resized_file)) {
                unlink($resized_file);
            }
     
            if (!empty($uploaded_image)) {
                $uploaded_image->delete();
            }
     
            return Response::json(['message' => 'Fiichier supprimé'], 200);
        }
    
        public function deletePhoto($id){
    
            $photo = Bienphoto::where('id', $id)->first();
            $photo->delete();
            return back()->with('ok', __("Photo supprimée"));
        }
    
    /** Fonction de téléchargement des photos du bien document
    * @author jean-philippe
    * @param  App\Models\Bienphoto
    * @return \Illuminate\Http\Response
    **/ 
    public function getPhoto( $photo_id){
    
        $photo = Bienphoto::where('id',$photo_id)->firstorfail();
    
        $path = public_path('images\photos_bien\\'.$photo->filename) ;
        return response()->download($path);
    }
    
    
    
    
    /** Fonction de téléchargement des photos du bien document
    * @author jean-philippe
    * @param  App\Models\Bienphoto
    * @return \Illuminate\Http\Response
    **/ 
    
    public function updatePhoto(Request $request){
    
        //    return $list_photo;
        $tab_list = json_decode($request["list"], true);
        $i = 0; 
        while($i < sizeof($tab_list)){
            $photo = Bienphoto::where('id',$tab_list[$i])->firstorfail();
            $photo->image_position = $i +1;
            $photo->update();
            $i++;
        }
    
        return Response::json([
            'message' => $tab_list
        ], 200);
    }
    
    
    ///////// ########## MODIFICATION D'UN BIEN ############
    
    /** Fonction de mise à jour des biens
    * @author jean-philippe
    * @param  App\Models\Bien
    * @return \Illuminate\Http\Response
    **/ 
    
    public function update(Bien $bien, Request $request){
    
      
        // return $request;
    

    
        $biendetail = Biendetail::where('bien_id',$bien->id)->first();
    
    
    
        // return $biendetail;
        
        if($request["type_update"] == "caracteristique"){
    
            $bien->titre_annonce = $request['titre_annonce'];
            $bien->description_annonce = $request['description_annonce'];
            $bien->titre_annonce_vitrine = $request['titre_annonce_vitrine'];
            $bien->description_annonce_vitrine = $request['description_annonce_vitrine'];
            $bien->titre_annonce_privee = $request['titre_annonce_privee'];
            $bien->description_annonce_privee = $request['description_annonce_privee'];
    
            $biendetail->agen_inter_nb_chambre = $request['nb_chambre_agencement_interieur'];
            $biendetail->agen_inter_nb_salle_bain = $request['nb_salle_bain_agencement_interieur'];
            $biendetail->agen_inter_nb_salle_eau = $request['nb_salle_eau_agencement_interieur'];
            $biendetail->agen_inter_nb_wc = $request['nb_wc_agencement_interieur'];
            $biendetail->agen_inter_nb_lot = $request['nb_lot_agencement_interieur'];
            $biendetail->agen_inter_nb_couchage = $request['nb_couchage_agencement_interieur'];
            $biendetail->agen_inter_nb_niveau = $request['nb_niveau_agencement_interieur'];
            $biendetail->agen_inter_grenier_comble = $request['grenier_comble_agencement_interieur'];
            $biendetail->agen_inter_buanderie = $request['buanderie_agencement_interieur'];
            $biendetail->agen_inter_meuble = $request['meuble_agencement_interieur'];
            $biendetail->agen_inter_surface_carrez = $request['surface_carrez_agencement_interieur'];
            $biendetail->agen_inter_surface_habitable = $request['surface_habitable_agencement_interieur'];      
            $biendetail->agen_inter_surface_sejour = $request['surface_sejour_agencement_interieur'];      
            $biendetail->agen_inter_cuisine_type = $request['cuisine_type_agencement_interieur'];      
            $biendetail->agen_inter_cuisine_etat = $request['cuisine_etat_agencement_interieur'];      
            $biendetail->agen_inter_situation_exposition = $request['situation_exposition_agencement_interieur'];      
            $biendetail->agen_inter_situation_vue = $request['situation_vue_agencement_interieur'];      
            $biendetail->agen_exter_mitoyennete = $request['mitoyennete_agencement_exterieur'];      
            $biendetail->agen_exter_etage = $request['etages_agencement_exterieur'];      
            $biendetail->agen_exter_terrasse = $request['terrasse_agencement_exterieur'];      
            $biendetail->agen_exter_nb_terrasse = $request['nombre_terrasse_agencement_exterieur'];        
            $biendetail->agen_exter_surface_terrasse = $request['surface_terrasse_agencement_exterieur'];
            $biendetail->agen_exter_plain_pied = $request['plain_pied_agencement_exterieur'];
            $biendetail->agen_exter_sous_sol = $request['sous_sol_agencement_exterieur'];
            $biendetail->agen_exter_surface_jardin = $request['surface_jardin_agencement_exterieur'];
            $biendetail->agen_exter_privatif_jardin = $request['privatif_jardin_agencement_exterieur'];
            $biendetail->agen_exter_type_cave = $request['type_cave_agencement_exterieur'];
            $biendetail->agen_exter_surface_cave = $request['surface_cave_agencement_exterieur'];
            $biendetail->agen_exter_balcon = $request['balcon_agencement_exterieur'];
            $biendetail->agen_exter_nb_balcon = $request['nb_balcon_agencement_exterieur'];
            $biendetail->agen_exter_surface_balcon = $request['surface_balcon_agencement_exterieur'];
            $biendetail->agen_exter_loggia = $request['loggia_agencement_exterieur'];
            $biendetail->agen_exter_surface_loggia = $request['surface_loggia_agencement_exterieur'];
            $biendetail->agen_exter_veranda = $request['veranda_agencement_exterieur'];
            $biendetail->agen_exter_surface_veranda = $request['surface_veranda_agencement_exterieur'];
            $biendetail->agen_exter_nb_garage = $request['nombre_garage_agencement_exterieur'];
            $biendetail->agen_exter_surface_garage = $request['surface_garage_agencement_exterieur'];
            $biendetail->agen_exter_parking_interieur = $request['parking_interieur_agencement_exterieur'];
            $biendetail->agen_exter_parking_exterieur = $request['parking_exterieur_agencement_exterieur'];
            $biendetail->agen_exter_statut_piscine = $request['statut_piscine_agencement_exterieur'];
            $biendetail->agen_exter_dimension_piscine = $request['dimension_piscine_agencement_exterieur'];
            $biendetail->agen_exter_volume_piscine = $request['volume_piscine_agencement_exterieur'];
            $biendetail->terrain_surface_terrain = $request['surface_terrain'];
            $biendetail->terrain_constructible = $request['constructible_terrain'];
            $biendetail->terrain_surface_constructible = $request['surface_constructible_terrain'];
            $biendetail->terrain_topographie = $request['topographie_terrain'];
            $biendetail->terrain_emprise_au_sol = $request['emprise_au_sol_terrain'];
            $biendetail->terrain_emprise_au_sol_residuelle = $request['emprise_au_sol_residuelle_terrain'];
            $biendetail->terrain_shon = $request['shon_terrain'];
            $biendetail->terrain_ces = $request['ces_terrain'];
            $biendetail->terrain_pos = $request['pos_terrain'];
            $biendetail->terrain_codification_plu = $request['codification_plu_terrain'];
            $biendetail->terrain_droit_de_passage = $request['droit_de_passage_terrain'];
            $biendetail->terrain_reference_cadastrale = $request['reference_cadastrale_terrain'];
            $biendetail->terrain_piscinable = $request['piscinable_terrain'];
            $biendetail->terrain_arbore = $request['arbore_terrain'];
            $biendetail->terrain_viabilise = $request['viabilise_terrain'];
            $biendetail->terrain_cloture = $request['cloture_terrain'];
            $biendetail->terrain_divisible = $request['divisible_terrain'];
            $biendetail->terrain_possiblite_egout = $request['possiblite_egout_terrain'];
            $biendetail->terrain_info_copopriete = $request['info_copopriete_terrain'];
            $biendetail->terrain_acces = $request['acces_terrain'];
            $biendetail->terrain_raccordement_eau = $request['raccordement_eau_terrain'];
            $biendetail->terrain_raccordement_gaz = $request['raccordement_gaz_terrain'];
            $biendetail->terrain_raccordement_electricite = $request['raccordement_electricite_terrain'];
            $biendetail->terrain_raccordement_telephone = $request['raccordement_telephone_terrain'];
            $biendetail->equipement_format = $request['format_equipement'];
            $biendetail->equipement_type = $request['type_equipement'];
            $biendetail->equipement_energie = $request['energie_equipement'];
            $biendetail->equipement_ascenseur = $request['ascenseur_equipement'];
            $biendetail->equipement_acces_handicape = $request['acces_handicape_equipement'];
            $biendetail->equipement_climatisation = $request['climatisation_equipement'];
            $biendetail->equipement_climatisation_specification = $request['climatisation_specification_equipement'];
            $biendetail->equipement_eau_alimentation = $request['eau_alimentation_equipement'];
            $biendetail->equipement_eau_assainissement = $request['eau_assainissement_equipement'];
            $biendetail->equipement_eau_chaude_distribution = $request['eau_chaude_distribution_equipement'];
            $biendetail->equipement_eau_chaude_energie = $request['eau_chaude_energie_equipement'];
            $biendetail->equipement_cheminee = $request['cheminee_equipement'];
            $biendetail->equipement_arrosage = $request['arrosage_automatique_equipement'];
            $biendetail->equipement_barbecue = $request['barbecue_equipement'];
            $biendetail->equipement_tennis = $request['tennis_equipement'];
            $biendetail->equipement_local_a_velo = $request['local_a_velo_equipement'];
            $biendetail->equipement_volet_electrique = $request['volet_electrique_equipement'];
            $biendetail->equipement_gardien = $request['gardien_equipement'];
            $biendetail->equipement_double_vitrage = $request['double_vitrage_equipement'];
            $biendetail->equipement_triple_vitrage = $request['triple_vitrage_equipement'];
            $biendetail->equipement_cable = $request['cable_equipement'];
            $biendetail->equipement_securite_porte_blinde = $request['securite_porte_blinde_equipement'];
            $biendetail->equipement_securite_interphone = $request['securite_interphone_equipement'];
            $biendetail->equipement_securite_visiophone = $request['securite_visiophone_equipement'];
            $biendetail->equipement_securite_alarme = $request['securite_alarme_equipement'];
            $biendetail->equipement_securite_digicode = $request['securite_digicode_equipement'];
            $biendetail->equipement_securite_detecteur_de_fumee = $request['securite_detecteur_de_fumee_equipement'];
            $biendetail->equipement_portail_electrique = $request['portail_electrique_equipement'];
            $biendetail->equipement_cuisine_ete = $request['cuisine_ete_equipement'];
            $biendetail->diagnostic_annee_construction = $request['annee_construction_diagnostic'];
            $biendetail->diagnostic_dpe_bien_soumi = $request['dpe_bien_soumi_diagnostic'];
            $biendetail->diagnostic_dpe_vierge = $request['dpe_vierge_diagnostic'];
            $biendetail->diagnostic_dpe_consommation = $request['dpe_consommation_diagnostic'];
            $biendetail->diagnostic_dpe_ges = $request['dpe_ges_diagnostic'];
            $biendetail->diagnostic_dpe_date = $request['dpe_diagnostic'];
            $biendetail->diagnostic_etat_exterieur = $request['etat_exterieur_diagnostic'];
            $biendetail->diagnostic_etat_interieur = $request['etat_interieur_diagnostic'];
            $biendetail->diagnostic_surface_annexe = $request['surface_annexe_diagnostic'];
            $biendetail->diagnostic_etat_parasitaire = $request['etat_parasitaire_diagnostic'];
            $biendetail->diagnostic_etat_parasitaire_date = $request['etat_parasitaire_date_diagnostic'];
            $biendetail->diagnostic_etat_parasitaire_commentaire = $request['etat_parasitaire_commentaire_diagnostic'];
            $biendetail->diagnostic_amiante = $request['amiante_diagnostic'];
            $biendetail->diagnostic_amiante_date = $request['amiante_date_diagnostic'];
            $biendetail->diagnostic_amiante_commentaire = $request['amiante_commentaire_diagnostic'];
            $biendetail->diagnostic_electrique = $request['electrique_diagnostic'];
            $biendetail->diagnostic_electrique_date = $request['electrique_date_diagnostic'];
            $biendetail->diagnostic_electrique_commentaire = $request['electrique_commentaire_diagnostic'];
            $biendetail->diagnostic_loi_carrez = $request['loi_carrez_diagnostic'];
            $biendetail->diagnostic_loi_carrez_date = $request['loi_carrez_date_diagnostic'];
            $biendetail->diagnostic_loi_carrez_commentaire = $request['loi_carrez_commentaire_diagnostic'];
            $biendetail->diagnostic_risque_nat = $request['risque_nat_diagnostic'];
            $biendetail->diagnostic_risque_nat_date = $request['risque_nat_date_diagnostic'];
            $biendetail->diagnostic_risque_nat_commentaire = $request['risque_nat_commentaire_diagnostic'];
            $biendetail->diagnostic_plomb = $request['plomb_diagnostic'];
            $biendetail->diagnostic_plomb_date = $request['plomb_date_diagnostic'];
            $biendetail->diagnostic_plomb_commentaire = $request['plomb_commentaire_diagnostic'];
            $biendetail->diagnostic_gaz = $request['gaz_diagnostic'];
            $biendetail->diagnostic_gaz_date = $request['gaz_date_diagnostic'];
            $biendetail->diagnostic_gaz_commentaire = $request['gaz_commentaire_diagnostic'];
            $biendetail->diagnostic_assainissement = $request['assainissement_diagnostic'];
            $biendetail->diagnostic_assainissement_date = $request['assainissement_date_diagnostic'];
            $biendetail->diagnostic_assainissement_commentaire = $request['assainissement_commentaire_diagnostic'];
            
    
        }
        elseif($request["type_update"] == "prix"){
            $bien->prix_public = $request['prix_public'];
            $bien->prix_prive = $request['prix_prive'];
            $bien->loyer = $request['loyer'];
            $bien->complement_loyer = $request['complement_loyer'];
            $bien->honoraire_acquereur = $request['honoraire_acquereur_info_fin'];
            $bien->honoraire_vendeur = $request['honoraire_vendeur_info_fin'];
            $bien->estimation_valeur = $request['estimation_valeur_info_fin'];
            $bien->estimation_date = $request['estimation_date_info_fin'];
            $bien->viager_prix_bouquet = $request['viager_valeur_info_fin'];
            $bien->viager_rente_mensuelle = $request['viager_rente_mensuelle_info_fin'];
            $bien->travaux_a_prevoir = $request['travaux_a_prevoir_info_fin'];
            $bien->depot_garanti = $request['depot_garanti_info_fin'];
            $bien->taxe_habitation = $request['taxe_habitation_info_fin'];
            $bien->taxe_fonciere = $request['taxe_fonciere_info_fin'];
            $bien->charge_mensuelle_total = $request['charge_mensuelle_total_info_fin'];
            $bien->charge_mensuelle_info = $request['charge_mensuelle_info_info_fin'];
            $biendetail->dossier_dispo_numero = $request['numero_dossier_dispo'];
            $biendetail->dossier_dispo_dossier_cree_le = $request['dossier_cree_le_dossier_dispo'];
            $biendetail->dossier_dispo_disponibilite_immediate = $request['disponibilite_immediate_dossier_dispo'];
            $biendetail->dossier_dispo_disponible_le = $request['disponible_le_dossier_dispo'];
            $biendetail->dossier_dispo_liberation_le = $request['liberation_le_dossier_dispo'];
    
        }
        elseif($request["type_update"] == "secteur"){
            
            $bien->pays_annonce = $request['pays_annonce_secteur'];
            $bien->adresse_bien = $request['adresse_bien_secteur'];
            $bien->complement_adresse = $request['complement_adresse_secteur'];
            $bien->quartier = $request['quartier_secteur'];
            $bien->secteur = $request['secteur_secteur'];
            $bien->immeuble_batiment = $request['immeuble_batiment_secteur'];
            $bien->transport_a_proximite = $request['transport_a_proximite_secteur'];
            $bien->proximite = $request['proximite_secteur'];
            $bien->environnement = $request['environnement_secteur'];
    
        }
    
        // Sauvegarde du bien

        $biendetail->update();
        $bien->update();
       
    
    }
    
    /** Fonction permettant d'imprimer une fiche de bien
    * @author jean-philippe
    * @param  App\Models\Bien
    * @param  string type_fiche
    * @param  string action
    * @return \Illuminate\Http\Response
    **/ 
    public function impressionFiche(Bien $bien, $type_fiche, $action){
    
        $bien = $bien;
        // return view('compenents.biens.show.ficheVisite',compact('bien'));
        if($type_fiche == "visite"){
    
            $pdf = PDF::loadView('components.biens.show.ficheVisite',compact('bien'));
            if($action == "print"){
                return $pdf->stream('fiche_visite.pdf');
            }
            elseif($action == "download"){
                return $pdf->download('fiche_visite.pdf');
            }
        }
        elseif($type_fiche == "privee"){
    
            $pdf = PDF::loadView('components.biens.show.fichePrivee',compact('bien'));
    
            if($action == "print"){
                return $pdf->stream('fiche_privee.pdf');
            }
            elseif($action == "download"){
                return $pdf->download('fiche_privee.pdf');
            }
        }
           
    
    }
    
}
