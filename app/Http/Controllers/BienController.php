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
    
    
        public function create(){
            $user = User::find(1)->get();
            return view('bien.add',compact('user'));
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
            

    
    
            $Bien = Bien::create([
                "type_offre"=> $request['type_offre'],
                "type_bien"=> $request['type_bien'],
                "user_id"=> auth()->id(),
            ]);
    
    
    
            $Biendetail = Biendetail::create([
                "bien_id" => $Bien->id,
            ]);
   

            
    
            if($request['type_offre'] == "vente"){         // Vente
    
                if($request['type_bien'] == "maison"){
    
                    $Bien->type_type_bien = $request['type_maison_vente_maison'];
                    $Bien->titre_annonce = $request['titre_annonce_vente_maison'];
                    $Bien->description_annonce = $request['description_annonce_vente_maison'];                
                    $Bien->surface_habitable = $request['surface_habitable_vente_maison'];
                    $Bien->surface_terrain = $request['surface_terrain_vente_maison']; // maison
                    $Bien->nombre_piece = $request['nb_piece_vente_maison'];
                    $Bien->nombre_chambre = $request['nb_chambres_vente_maison'];
                    $Bien->nombre_niveau = $request['nombre_niveau_vente_maison'];
    
                    $Bien->jardin = $request['jardin_vente_maison'];// maison
                    $Bien->jardin_surface = $request['surface_jardin_vente_maison'];// maison
                    $Bien->jardin_privatif = $request['privatif_jardin_vente_maison'];// maison
                    $Bien->jardin_volume = $request['volume_piscine_vente_maison'];// maison
                    $Bien->piscine = $request['piscine_vente_maison'];// maison
                    $Bien->piscine_statut = $request['statut_piscine_vente_maison'];// maison
                    $Bien->piscine_nature = $request['nature_piscine_vente_maison'];// maison                
                    $Bien->jardin_pool_house = $request['pool_house_piscine_vente_maison'];// maison
                    $Bien->jardin_chauffee = $request['chauffee_piscine_vente_maison'];// maison
                    $Bien->jardin_couverte = $request['couverte_piscine_vente_maison'];// maison
    
                    $Bien->pays = $request['pays_vente_maison'];
                    $Bien->ville = $request['ville_vente_maison'];
                    $Bien->code_postal = $request['code_postal_vente_maison'];
                    // $Bien->numero_dossier = $request['numero_dossier_vente_maison'];
                    // $Bien->date_creation_dossier = $request['date_creation_dossier_vente_maison'];
                    $Bien->nombre_garage = $request['nb_garage_vente_maison'];
                    $Bien->exposition_situation = $request['exposition_situation_vente_maison'];
                    $Bien->vue_situation = $request['vue_situation_vente_maison'];                
                    
                }
                elseif($request['type_bien'] == "appartement"){
                   
                    $Bien->type_type_bien = $request['type_appartement_vente_appart'];
                    $Bien->titre_annonce = $request['titre_annonce_vente_appart'];
                    $Bien->description_annonce = $request['description_annonce_vente_appart'];                
                    $Bien->surface_habitable = $request['surface_habitable_vente_appart'];
                    $Bien->nombre_piece = $request['nb_piece_vente_appart'];
                    $Bien->nombre_chambre = $request['nb_chambres_vente_appart'];
                    $Bien->nombre_niveau = $request['nombre_niveau_vente_appart'];
                    $Bien->pays = $request['pays_vente_appart'];
                    $Bien->ville = $request['ville_vente_appart'];
                    $Bien->code_postal = $request['code_postal_vente_appart'];
                    // $Bien->numero_dossier = $request['numero_dossier_vente_appart'];
                    // $Bien->date_creation_dossier = $request['date_creation_dossier_vente_appart'];
                    $Bien->nombre_garage = $request['nb_garage_vente_appart'];
                    $Bien->exposition_situation = $request['exposition_situation_vente_appart'];
                    $Bien->vue_situation = $request['vue_situation_vente_appart'];
    
                }
                elseif($request['type_bien'] == "terrain"){
    
                    $Bien->type_type_bien = "Terrain";
                    $Bien->titre_annonce = $request['titre_annonce_vente_terrain'];
                    $Bien->description_annonce = $request['description_annonce_vente_terrain'];
                    $Bien->surface_habitable = $request['surface_habitable_vente_terrain'];
                    $Bien->pays = $request['pays_vente_terrain'];
                    $Bien->ville = $request['ville_vente_terrain'];
                    $Bien->code_postal = $request['code_postal_vente_terrain'];
                    // $Bien->numero_dossier = $request['numero_dossier_vente_terrain'];
                    // $Bien->date_creation_dossier = $request['date_creation_dossier_vente_terrain'];
    
                }
                elseif($request['type_bien'] == "autreType"){
    
                    $Bien->type_type_bien = $request['type_appartement_vente_autreType'];
                    $Bien->titre_annonce = $request['titre_annonce_vente_autreType'];
                    $Bien->description_annonce = $request['description_annonce_vente_autreType'];
                    $Bien->surface = $request['surface_vente_autreType'];
                    $Bien->surface_habitable = $request['surface_habitable_vente_autreType'];
                    $Bien->nombre_piece = $request['nb_piece_vente_autreType'];
                    $Bien->nombre_chambre = $request['nb_chambres_vente_autreType'];
                    $Bien->nombre_niveau = $request['nombre_niveau_vente_autreType'];
                    $Bien->jardin = $request['jardin_vente_autreType'];
                    $Bien->jardin_surface = $request['surface_jardin_vente_autreType'];
                    $Bien->jardin_privatif = $request['privatif_jardin_vente_autreType'];
                    $Bien->surface_terrain = $request['surface_terrain_vente_autreType'];
                    $Bien->piscine = $request['piscine_vente_autreType'];
                    $Bien->piscine_statut = $request['statut_piscine_vente_autreType'];
                    $Bien->piscine_nature = $request['nature_piscine_vente_autreType'];
                    $Bien->jardin_volume = $request['volume_piscine_vente_autreType'];
                    $Bien->jardin_pool_house = $request['pool_house_piscine_vente_autreType'];
                    $Bien->jardin_chauffee = $request['chauffee_piscine_vente_autreType'];
                    $Bien->jardin_couverte = $request['couverte_piscine_vente_autreType'];
                    $Bien->pays = $request['pays_vente_autreType'];
                    $Bien->ville = $request['ville_vente_autreType'];
                    $Bien->code_postal = $request['code_postal_vente_autreType'];
                    // $Bien->numero_dossier = $request['numero_dossier_vente_autreType'];
                    // $Bien->date_creation_dossier = $request['date_creation_dossier_vente_autreType'];
                    $Bien->nombre_garage = $request['nb_garage_vente_autreType'];
                    $Bien->exposition_situation = $request['exposition_situation_vente_autreType'];
                    $Bien->vue_situation = $request['vue_situation_vente_autreType'];
    
                }
                else{
    
                }
               
            }else{ // Location
                
                if($request['type_bien'] == "maison"){
    
                    $Bien->type_type_bien = $request['type_maison_location_maison'];
                    $Bien->titre_annonce = $request['titre_annonce_location_maison'];
                    $Bien->description_annonce = $request['description_annonce_location_maison'];
                    $Bien->duree_bail = $request['duree_bail_location_maison'];
                    $Bien->surface_habitable = $request['surface_habitable_location_maison'];
                    $Bien->nombre_piece = $request['nb_piece_location_maison'];
                    $Bien->nombre_chambre = $request['nb_chambres_location_maison'];
                    $Bien->nombre_niveau = $request['nombre_niveau_location_maison'];
                    $Bien->jardin = $request['jardin_location_maison'];
                    $Bien->jardin_surface = $request['surface_jardin_location_maison'];
                    $Bien->jardin_privatif = $request['privatif_jardin_location_maison'];
                    $Bien->surface_terrain = $request['surface_terrain_location_maison'];
                    $Bien->piscine = $request['piscine_location_maison'];
                    $Bien->piscine_statut = $request['statut_piscine_location_maison'];
                    $Bien->piscine_nature = $request['nature_piscine_location_maison'];
                    $Bien->jardin_volume = $request['volume_piscine_location_maison'];
                    $Bien->jardin_pool_house = $request['pool_house_piscine_location_maison'];
                    $Bien->jardin_chauffee = $request['chauffee_piscine_location_maison'];
                    $Bien->jardin_couverte = $request['couverte_piscine_location_maison'];                
                    $Bien->pays = $request['pays_location_maison'];
                    $Bien->ville = $request['ville_location_maison'];
                    $Bien->code_postal = $request['code_postal_location_maison'];
                    // $Bien->numero_dossier = $request['numero_dossier_location_maison'];
                    // $Bien->date_creation_dossier = $request['date_creation_dossier_location_maison'];
                    $Bien->meuble = $request['meuble_location_maison'];
                    $Bien->nombre_garage = $request['nb_garage_location_maison'];
                    $Bien->exposition_situation = $request['exposition_situation_location_maison'];
                    $Bien->vue_situation = $request['vue_situation_location_maison'];
    
                    
                    
                }
                elseif($request['type_bien'] == "appartement"){
    
                    $Bien->type_type_bien = $request['type_appartement_location_appart'];
                    $Bien->titre_annonce = $request['titre_annonce_location_appart'];
                    $Bien->description_annonce = $request['description_annonce_location_appart'];
                    $Bien->duree_bail = $request['duree_bail_location_appart'];              
                    $Bien->surface_habitable = $request['surface_habitable_location_appart'];
                    $Bien->nombre_piece = $request['nb_piece_location_appart'];
                    $Bien->nombre_chambre = $request['nb_chambres_location_appart'];
                    $Bien->nombre_niveau = $request['nombre_niveau_location_appart'];
                    $Bien->pays = $request['pays_location_appart'];
                    $Bien->ville = $request['ville_location_appart'];
                    $Bien->code_postal = $request['code_postal_location_appart'];
                    // $Bien->numero_dossier = $request['numero_dossier_location_appart'];
                    // $Bien->date_creation_dossier = $request['date_creation_dossier_location_appart'];
                    $Bien->meuble = $request['meuble_location_appart'];
                    $Bien->nombre_garage = $request['nb_garage_location_appart'];
                    $Bien->exposition_situation = $request['exposition_situation_location_appart'];
                    $Bien->vue_situation = $request['vue_situation_location_appart'];
                    
                }elseif($request['type_bien'] == "terrain"){
     
                    $Bien->titre_annonce = $request['titre_annonce_location_terrain'];
                    $Bien->description_annonce = $request['description_annonce_location_terrain'];
                    $Bien->duree_bail = $request['duree_bail_location_terrain'];
                    $Bien->surface_habitable = $request['surface_habitable_location_terrain'];
                    $Bien->pays = $request['pays_location_terrain'];
                    $Bien->ville = $request['ville_location_terrain'];
                    $Bien->code_postal = $request['code_postal_location_terrain'];
                    // $Bien->numero_dossier = $request['numero_dossier_location_terrain'];
                    // $Bien->date_creation_dossier = $request['date_creation_dossier_location_terrain'];
    
                }elseif($request['type_bien'] == "autreType"){
                    $Bien->type_type_bien = $request['type_appartement_location_autreType'];
                    $Bien->titre_annonce = $request['titre_annonce_location_autreType'];
                    $Bien->description_annonce = $request['description_annonce_location_autreType'];
                    $Bien->duree_bail = $request['duree_bail_location_autreType'];
                    $Bien->surface = $request['surface_location_autreType'];
                    $Bien->surface_habitable = $request['surface_habitable_location_autreType'];
                    $Bien->nombre_piece = $request['nb_piece_location_autreType'];
                    $Bien->nombre_chambre = $request['nb_chambres_location_autreType'];
                    $Bien->nombre_niveau = $request['nombre_niveau_location_autreType'];
                    $Bien->jardin = $request['jardin_location_autreType'];
                    $Bien->jardin_surface = $request['surface_jardin_location_autreType'];
                    $Bien->jardin_privatif = $request['privatif_jardin_location_autreType'];
                    $Bien->terrain_surface = $request['surface_terrain_location_autreType'];
                    $Bien->piscine = $request['piscine_location_autreType'];
                    $Bien->piscine_statut = $request['statut_piscine_location_autreType'];
                    $Bien->piscine_nature = $request['nature_piscine_location_autreType'];
                    $Bien->jardin_volume = $request['volume_piscine_location_autreType'];
                    $Bien->jardin_pool_house = $request['pool_house_piscine_location_autreType'];
                    $Bien->jardin_chauffee = $request['chauffee_piscine_location_autreType'];
                    $Bien->jardin_couverte = $request['couverte_piscine_location_autreType'];
                    $Bien->pays = $request['pays_location_autreType'];
                    $Bien->ville = $request['ville_location_autreType'];
                    $Bien->code_postal = $request['code_postal_location_autreType'];
                    // $Bien->numero_dossier = $request['numero_dossier_location_autreType'];
                    // $Bien->date_creation_dossier = $request['date_creation_dossier_location_autreType'];
                    $Bien->meuble = $request['meuble_location_autreType'];
                    $Bien->nombre_garage = $request['nb_garage_location_autreType'];
                    $Bien->exposition_situation = $request['exposition_situation_location_autreType'];
                    $Bien->vue_situation = $request['vue_situation_location_autreType'];
                    
    
                }
                else{
    
                }
    
    
            }
                   
            $Bien->titre_annonce_vitrine = $Bien->titre_annonce ;
            $Bien->description_annonce_vitrine = $Bien->description_annonce ;
            $Bien->titre_annonce_privee =  $Bien->titre_annonce ;
            $Bien->description_annonce_privee = $Bien->description_annonce ;            
    
            // secteur
            // à revoir serialiser les donnees
    
            $section_parcelle = array(array());
            for ($i=0 ; $i < sizeof($request['section_secteurs']) ; $i++) {
                $section_parcelle[$i][0] = $request['section_secteurs'][$i] ;
                $section_parcelle[$i][1] = $request['parcelle_secteurs'][$i] ;
            }
            $Bien->section_parcelle = serialize($section_parcelle);
            // fin
    
            $Bien->pays_annonce = $request['pays_annonce_secteur'];
            $Bien->adresse_bien = $request['adresse_bien_secteur'];
            $Bien->complement_adresse = $request['complement_adresse_secteur'];
            $Bien->quartier = $request['quartier_secteur'];
            $Bien->secteur = $request['secteur_secteur'];
            $Bien->immeuble_batiment = $request['immeuble_batiment_secteur'];
            $Bien->transport_a_proximite = $request['transport_a_proximite_secteur'];
            $Bien->proximite = $request['proximite_secteur'];
            $Bien->environnement = $request['environnement_secteur'];
            
         
            //composition   à sérialiser          
            $composition_piece = array(array());
            if(isset($request['piece_compositions'])){
    
                for ($i=0 ; $i < sizeof($request['piece_compositions'] ); $i++) {
                    
                    Biencomposition::create([
                        "bien_id" => $Bien->id,
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
            $Bien->prix_public = $request['prix_public_info_fin'];
            $Bien->prix_prive = $request['prix_net_info_fin'];        
            $Bien->honoraire_acquereur = $request['honoraire_acquereur_info_fin'];
            $Bien->part_acquereur = $request['part_acquereur_info_fin'];
            $Bien->taux_prix = $request['taux_prix_info_fin'];
            $Bien->honoraire_vendeur = $request['honoraire_vendeur_info_fin'];
            $Bien->part_vendeur = $request['part_vendeur_info_fin'];
            $Bien->taux_net = $request['taux_net_info_fin'];
            $Bien->complement_loyer = $request['complement_loyer'];
            $Bien->loyer = $request['loyer'];
            $Bien->estimation_date = $request['estimation_date_info_fin'];
            $Bien->viager_prix_bouquet = $request['viager_valeur_info_fin'];
            $Bien->viager_rente_mensuelle = $request['viager_rente_mensuelle_info_fin'];
            $Bien->estimation_valeur = $request['estimation_valeur_info_fin'];
            $Bien->travaux_a_prevoir = $request['travaux_a_prevoir_info_fin'];
            $Bien->depot_garanti = $request['depot_garanti_info_fin'];
            $Bien->taxe_habitation = $request['taxe_habitation_info_fin'];
            $Bien->taxe_fonciere = $request['taxe_fonciere_info_fin'];
            $Bien->charge_mensuelle_total = $request['charge_mensuelle_total_info_fin'];
            $Bien->charge_mensuelle_info = $request['charge_mensuelle_info_info_fin'];
     
             //fin
    
          //détails
            $Biendetail->particularite_particularite = $request['particularite_particularite'];
            $Biendetail->agen_inter_nb_chambre = $request['nb_chambre_agencement_interieur'];
            $Biendetail->agen_inter_nb_salle_bain = $request['nb_salle_bain_agencement_interieur'];
            $Biendetail->agen_inter_nb_salle_eau = $request['nb_salle_eau_agencement_interieur'];
            $Biendetail->agen_inter_nb_wc = $request['nb_wc_agencement_interieur'];
            $Biendetail->agen_inter_nb_lot = $request['nb_lot_agencement_interieur'];
            $Biendetail->agen_inter_nb_couchage = $request['nb_couchage_agencement_interieur'];
            $Biendetail->agen_inter_nb_niveau = $request['nb_niveau_agencement_interieur'];
            $Biendetail->agen_inter_grenier_comble = $request['grenier_comble_agencement_interieur'];
            $Biendetail->agen_inter_buanderie = $request['buanderie_agencement_interieur'];
            $Biendetail->agen_inter_meuble = $request['meuble_agencement_interieur'];
            $Biendetail->agen_inter_surface_carrez = $request['surface_carrez_agencement_interieur'];
            $Biendetail->agen_inter_surface_habitable = $request['surface_habitable_agencement_interieur'];
            $Biendetail->agen_inter_surface_sejour = $request['surface_sejour_agencement_interieur'];
            $Biendetail->agen_inter_cuisine_type = $request['cuisine_type_agencement_interieur'];
            $Biendetail->agen_inter_cuisine_etat = $request['cuisine_etat_agencement_interieur'];
            $Biendetail->agen_inter_situation_exposition = $request['situation_exposition_agencement_interieur'];
            $Biendetail->agen_inter_situation_vue = $request['situation_vue_agencement_interieur'];               
            $Biendetail->agen_exter_mitoyennete = $request['mitoyennete_agencement_exterieur'];
            $Biendetail->agen_exter_etage = $request['etages_agencement_exterieur'];
            $Biendetail->agen_exter_terrasse = $request['terrasse_agencement_exterieur'];
            $Biendetail->agen_exter_nb_terrasse = $request['nombre_terrasse_agencement_exterieur'];
            $Biendetail->agen_exter_surface_terrasse = $request['surface_terrasse_agencement_exterieur'];
            $Biendetail->agen_exter_plain_pied = $request['plain_pied_agencement_exterieur'];
            $Biendetail->agen_exter_sous_sol = $request['sous_sol_agencement_exterieur'];
            $Biendetail->agen_exter_surface_jardin = $request['surface_jardin_agencement_exterieur'];
            $Biendetail->agen_exter_privatif_jardin = $request['privatif_jardin_agencement_exterieur'];
            $Biendetail->agen_exter_type_cave = $request['type_cave_agencement_exterieur'];
            $Biendetail->agen_exter_surface_cave = $request['surface_cave_agencement_exterieur'];
            $Biendetail->agen_exter_balcon = $request['balcon_agencement_exterieur'];
            $Biendetail->agen_exter_nb_balcon = $request['nb_balcon_agencement_exterieur'];
            $Biendetail->agen_exter_surface_balcon = $request['surface_balcon_agencement_exterieur'];
            $Biendetail->agen_exter_loggia = $request['loggia_agencement_exterieur'];
            $Biendetail->agen_exter_surface_loggia = $request['surface_loggia_agencement_exterieur'];
            $Biendetail->agen_exter_veranda = $request['veranda_agencement_exterieur'];
            $Biendetail->agen_exter_surface_veranda = $request['surface_veranda_agencement_exterieur'];
            $Biendetail->agen_exter_nb_garage = $request['nombre_garage_agencement_exterieur'];
            $Biendetail->agen_exter_surface_garage = $request['surface_garage_agencement_exterieur'];
            $Biendetail->agen_exter_parking_interieur = $request['parking_interieur_agencement_exterieur'];
            $Biendetail->agen_exter_parking_exterieur = $request['parking_exterieur_agencement_exterieur'];
            $Biendetail->agen_exter_statut_piscine = $request['statut_piscine_agencement_exterieur'];
            $Biendetail->agen_exter_dimension_piscine = $request['dimension_piscine_agencement_exterieur'];
            $Biendetail->agen_exter_volume_piscine = $request['volume_piscine_agencement_exterieur'];  
    
            $Biendetail->terrain_surface_terrain = $request['surface_terrain'];
            $Biendetail->terrain_constructible = $request['constructible_terrain'];
            $Biendetail->terrain_surface_constructible = $request['surface_constructible_terrain'];
            $Biendetail->terrain_topographie = $request['topographie_terrain'];
            $Biendetail->terrain_emprise_au_sol = $request['emprise_au_sol_terrain'];
            $Biendetail->terrain_emprise_au_sol_residuelle = $request['emprise_au_sol_residuelle_terrain'];
            $Biendetail->terrain_shon = $request['shon_terrain'];
            $Biendetail->terrain_ces = $request['ces_terrain'];
            $Biendetail->terrain_pos = $request['pos_terrain'];
            $Biendetail->terrain_codification_plu = $request['codification_plu_terrain'];
            $Biendetail->terrain_droit_de_passage = $request['droit_de_passage_terrain'];
            $Biendetail->terrain_reference_cadastrale = $request['reference_cadastrale_terrain'];
            $Biendetail->terrain_piscinable = $request['piscinable_terrain'];
            $Biendetail->terrain_arbore = $request['arbore_terrain'];
            $Biendetail->terrain_viabilise = $request['viabilise_terrain'];
            $Biendetail->terrain_cloture = $request['cloture_terrain'];
            $Biendetail->terrain_divisible = $request['divisible_terrain'];
            $Biendetail->terrain_possiblite_egout = $request['possiblite_egout_terrain'];
            $Biendetail->terrain_info_copopriete = $request['info_copopriete_terrain'];
            $Biendetail->terrain_acces = $request['acces_terrain'];
            $Biendetail->terrain_raccordement_eau = $request['raccordement_eau_terrain'];
            $Biendetail->terrain_raccordement_gaz = $request['raccordement_gaz_terrain'];
            $Biendetail->terrain_raccordement_electricite = $request['raccordement_electricite_terrain'];
            $Biendetail->terrain_raccordement_telephone = $request['raccordement_telephone_terrain'];
           
            $Biendetail->equipement_format = $request['format_equipement'];
            $Biendetail->equipement_type = $request['type_equipement'];
            $Biendetail->equipement_energie = $request['energie_equipement'];
            $Biendetail->equipement_ascenseur = $request['ascenseur_equipement'];
            $Biendetail->equipement_acces_handicape = $request['acces_handicape_equipement'];
            $Biendetail->equipement_climatisation = $request['climatisation_equipement'];
            $Biendetail->equipement_climatisation_specification = $request['climatisation_specification_equipement'];      
            $Biendetail->equipement_eau_alimentation = $request['eau_alimentation_equipement'];
            $Biendetail->equipement_eau_assainissement = $request['eau_assainissement_equipement'];
            $Biendetail->equipement_eau_chaude_distribution = $request['eau_chaude_distribution_equipement'];
            $Biendetail->equipement_eau_chaude_energie = $request['eau_chaude_energie_equipement'];
            $Biendetail->equipement_cheminee = $request['cheminee_equipement'];
            $Biendetail->equipement_arrosage = $request['arrosage_automatique_equipement'];
            $Biendetail->equipement_barbecue = $request['barbecue_equipement'];
            $Biendetail->equipement_tennis = $request['tennis_equipement'];
            $Biendetail->equipement_local_a_velo = $request['local_a_velo_equipement'];
            $Biendetail->equipement_volet_electrique = $request['volet_electrique_equipement'];
            $Biendetail->equipement_gardien = $request['gardien_equipement'];
            $Biendetail->equipement_double_vitrage = $request['double_vitrage_equipement'];
            $Biendetail->equipement_triple_vitrage = $request['triple_vitrage_equipement'];
            $Biendetail->equipement_cable = $request['cable_equipement'];
            $Biendetail->equipement_securite_porte_blinde = $request['securite_porte_blinde_equipement'];
            $Biendetail->equipement_securite_interphone = $request['securite_interphone_equipement'];
            $Biendetail->equipement_securite_visiophone = $request['securite_visiophone_equipement'];
            $Biendetail->equipement_securite_alarme = $request['securite_alarme_equipement'];
            $Biendetail->equipement_securite_digicode = $request['securite_digicode_equipement'];
            $Biendetail->equipement_securite_detecteur_de_fumee = $request['securite_detecteur_de_fumee_equipement'];
            $Biendetail->equipement_portail_electrique = $request['portail_electrique_equipement'];
            $Biendetail->equipement_cuisine_ete = $request['cuisine_ete_equipement'];
    
            $Biendetail->diagnostic_annee_construction = $request['annee_construction_diagnostic'];
            $Biendetail->diagnostic_dpe_bien_soumi = $request['dpe_bien_soumi_diagnostic'];
            $Biendetail->diagnostic_dpe_vierge = $request['dpe_vierge_diagnostic'];
            $Biendetail->diagnostic_dpe_consommation = $request['dpe_consommation_diagnostic'];
            $Biendetail->diagnostic_dpe_ges = $request['dpe_ges_diagnostic'];
            $Biendetail->diagnostic_dpe_date = $request['dpe_diagnostic'];
            $Biendetail->diagnostic_etat_exterieur = $request['etat_exterieur_diagnostic'];
            $Biendetail->diagnostic_etat_interieur = $request['etat_interieur_diagnostic'];
            $Biendetail->diagnostic_surface_annexe = $request['surface_annexe_diagnostic'];
            $Biendetail->diagnostic_etat_parasitaire = $request['etat_parasitaire_diagnostic'];
            $Biendetail->diagnostic_etat_parasitaire_date = $request['etat_parasitaire_date_diagnostic'];
            $Biendetail->diagnostic_etat_parasitaire_commentaire = $request['etat_parasitaire_commentaire_diagnostic'];
            $Biendetail->diagnostic_amiante = $request['amiante_diagnostic'];
            $Biendetail->diagnostic_amiante_date = $request['amiante_date_diagnostic'];
            $Biendetail->diagnostic_amiante_commentaire = $request['amiante_commentaire_diagnostic'];
            $Biendetail->diagnostic_electrique = $request['electrique_diagnostic'];
            $Biendetail->diagnostic_electrique_date = $request['electrique_date_diagnostic'];
            $Biendetail->diagnostic_electrique_commentaire = $request['electrique_commentaire_diagnostic'];
            $Biendetail->diagnostic_loi_carrez = $request['loi_carrez_diagnostic'];
            $Biendetail->diagnostic_loi_carrez_date = $request['loi_carrez_date_diagnostic'];
            $Biendetail->diagnostic_loi_carrez_commentaire = $request['loi_carrez_commentaire_diagnostic'];
            $Biendetail->diagnostic_risque_nat = $request['risque_nat_diagnostic'];
            $Biendetail->diagnostic_risque_nat_date = $request['risque_nat_date_diagnostic'];
            $Biendetail->diagnostic_risque_nat_commentaire = $request['risque_nat_commentaire_diagnostic'];
            $Biendetail->diagnostic_plomb = $request['plomb_diagnostic'];
            $Biendetail->diagnostic_plomb_date = $request['plomb_date_diagnostic'];
            $Biendetail->diagnostic_plomb_commentaire = $request['plomb_commentaire_diagnostic'];
            $Biendetail->diagnostic_gaz = $request['gaz_diagnostic'];
            $Biendetail->diagnostic_gaz_date = $request['gaz_date_diagnostic'];
            $Biendetail->diagnostic_gaz_commentaire = $request['gaz_commentaire_diagnostic'];
            $Biendetail->diagnostic_assainissement = $request['assainissement_diagnostic'];
            $Biendetail->diagnostic_assainissement_date = $request['assainissement_date_diagnostic'];
            $Biendetail->diagnostic_assainissement_commentaire = $request['assainissement_commentaire_diagnostic'];
    
            $Biendetail->copropriete_bien_en = $request['bien_en_copropriete'];
            $Biendetail->copropriete_numero_lot = $request['numero_lot_info_copropriete'];
            $Biendetail->copropriete_nombre_lot = $request['nombre_lot_info_copropriete'];
            $Biendetail->copropriete_quote_part_charge = $request['quote_part_charge_info_copropriete'];
            $Biendetail->copropriete_montant_fond_travaux = $request['montant_fond_travaux_info_copropriete'];
            $Biendetail->copropriete_plan_sauvegarde = $request['plan_sauvegarde_info_copropriete'];
            $Biendetail->copropriete_statut_syndic = $request['statut_syndic_info_copropriete'];
            $Biendetail->dossier_dispo_numero = $request['numero_dossier_dispo'];
            $Biendetail->dossier_dispo_dossier_cree_le = $request['dossier_cree_le_dossier_dispo'];
            $Biendetail->dossier_dispo_disponibilite_immediate = $request['disponibilite_immediate_dossier_dispo'];
            $Biendetail->dossier_dispo_disponible_le = $request['disponible_le_dossier_dispo'];
            $Biendetail->dossier_dispo_liberation_le = $request['liberation_le_dossier_dispo'];
    
            $Biendetail->update();
           
    
         
    
            // Sauvegarde du bien
            $Bien->update();
    
    
             $bien_id = Crypt::encrypt($Bien->id); 
            
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
       
    
        return view("bien.show",compact(['bien','bien_id_crypt','liste_photos']));
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
    
    public function update(Bien $Bien, Request $request){
    
      
        // return $request;
    

    
        $Biendetail = Biendetail::where('bien_id',$Bien->id)->first();
    
    
    
        // return $Biendetail;
        
        if($request["type_update"] == "caracteristique"){
    
            $Bien->titre_annonce = $request['titre_annonce'];
            $Bien->description_annonce = $request['description_annonce'];
            $Bien->titre_annonce_vitrine = $request['titre_annonce_vitrine'];
            $Bien->description_annonce_vitrine = $request['description_annonce_vitrine'];
            $Bien->titre_annonce_privee = $request['titre_annonce_privee'];
            $Bien->description_annonce_privee = $request['description_annonce_privee'];
    
            $Biendetail->agen_inter_nb_chambre = $request['nb_chambre_agencement_interieur'];
            $Biendetail->agen_inter_nb_salle_bain = $request['nb_salle_bain_agencement_interieur'];
            $Biendetail->agen_inter_nb_salle_eau = $request['nb_salle_eau_agencement_interieur'];
            $Biendetail->agen_inter_nb_wc = $request['nb_wc_agencement_interieur'];
            $Biendetail->agen_inter_nb_lot = $request['nb_lot_agencement_interieur'];
            $Biendetail->agen_inter_nb_couchage = $request['nb_couchage_agencement_interieur'];
            $Biendetail->agen_inter_nb_niveau = $request['nb_niveau_agencement_interieur'];
            $Biendetail->agen_inter_grenier_comble = $request['grenier_comble_agencement_interieur'];
            $Biendetail->agen_inter_buanderie = $request['buanderie_agencement_interieur'];
            $Biendetail->agen_inter_meuble = $request['meuble_agencement_interieur'];
            $Biendetail->agen_inter_surface_carrez = $request['surface_carrez_agencement_interieur'];
            $Biendetail->agen_inter_surface_habitable = $request['surface_habitable_agencement_interieur'];      
            $Biendetail->agen_inter_surface_sejour = $request['surface_sejour_agencement_interieur'];      
            $Biendetail->agen_inter_cuisine_type = $request['cuisine_type_agencement_interieur'];      
            $Biendetail->agen_inter_cuisine_etat = $request['cuisine_etat_agencement_interieur'];      
            $Biendetail->agen_inter_situation_exposition = $request['situation_exposition_agencement_interieur'];      
            $Biendetail->agen_inter_situation_vue = $request['situation_vue_agencement_interieur'];      
            $Biendetail->agen_exter_mitoyennete = $request['mitoyennete_agencement_exterieur'];      
            $Biendetail->agen_exter_etage = $request['etages_agencement_exterieur'];      
            $Biendetail->agen_exter_terrasse = $request['terrasse_agencement_exterieur'];      
            $Biendetail->agen_exter_nb_terrasse = $request['nombre_terrasse_agencement_exterieur'];        
            $Biendetail->agen_exter_surface_terrasse = $request['surface_terrasse_agencement_exterieur'];
            $Biendetail->agen_exter_plain_pied = $request['plain_pied_agencement_exterieur'];
            $Biendetail->agen_exter_sous_sol = $request['sous_sol_agencement_exterieur'];
            $Biendetail->agen_exter_surface_jardin = $request['surface_jardin_agencement_exterieur'];
            $Biendetail->agen_exter_privatif_jardin = $request['privatif_jardin_agencement_exterieur'];
            $Biendetail->agen_exter_type_cave = $request['type_cave_agencement_exterieur'];
            $Biendetail->agen_exter_surface_cave = $request['surface_cave_agencement_exterieur'];
            $Biendetail->agen_exter_balcon = $request['balcon_agencement_exterieur'];
            $Biendetail->agen_exter_nb_balcon = $request['nb_balcon_agencement_exterieur'];
            $Biendetail->agen_exter_surface_balcon = $request['surface_balcon_agencement_exterieur'];
            $Biendetail->agen_exter_loggia = $request['loggia_agencement_exterieur'];
            $Biendetail->agen_exter_surface_loggia = $request['surface_loggia_agencement_exterieur'];
            $Biendetail->agen_exter_veranda = $request['veranda_agencement_exterieur'];
            $Biendetail->agen_exter_surface_veranda = $request['surface_veranda_agencement_exterieur'];
            $Biendetail->agen_exter_nb_garage = $request['nombre_garage_agencement_exterieur'];
            $Biendetail->agen_exter_surface_garage = $request['surface_garage_agencement_exterieur'];
            $Biendetail->agen_exter_parking_interieur = $request['parking_interieur_agencement_exterieur'];
            $Biendetail->agen_exter_parking_exterieur = $request['parking_exterieur_agencement_exterieur'];
            $Biendetail->agen_exter_statut_piscine = $request['statut_piscine_agencement_exterieur'];
            $Biendetail->agen_exter_dimension_piscine = $request['dimension_piscine_agencement_exterieur'];
            $Biendetail->agen_exter_volume_piscine = $request['volume_piscine_agencement_exterieur'];
            $Biendetail->terrain_surface_terrain = $request['surface_terrain'];
            $Biendetail->terrain_constructible = $request['constructible_terrain'];
            $Biendetail->terrain_surface_constructible = $request['surface_constructible_terrain'];
            $Biendetail->terrain_topographie = $request['topographie_terrain'];
            $Biendetail->terrain_emprise_au_sol = $request['emprise_au_sol_terrain'];
            $Biendetail->terrain_emprise_au_sol_residuelle = $request['emprise_au_sol_residuelle_terrain'];
            $Biendetail->terrain_shon = $request['shon_terrain'];
            $Biendetail->terrain_ces = $request['ces_terrain'];
            $Biendetail->terrain_pos = $request['pos_terrain'];
            $Biendetail->terrain_codification_plu = $request['codification_plu_terrain'];
            $Biendetail->terrain_droit_de_passage = $request['droit_de_passage_terrain'];
            $Biendetail->terrain_reference_cadastrale = $request['reference_cadastrale_terrain'];
            $Biendetail->terrain_piscinable = $request['piscinable_terrain'];
            $Biendetail->terrain_arbore = $request['arbore_terrain'];
            $Biendetail->terrain_viabilise = $request['viabilise_terrain'];
            $Biendetail->terrain_cloture = $request['cloture_terrain'];
            $Biendetail->terrain_divisible = $request['divisible_terrain'];
            $Biendetail->terrain_possiblite_egout = $request['possiblite_egout_terrain'];
            $Biendetail->terrain_info_copopriete = $request['info_copopriete_terrain'];
            $Biendetail->terrain_acces = $request['acces_terrain'];
            $Biendetail->terrain_raccordement_eau = $request['raccordement_eau_terrain'];
            $Biendetail->terrain_raccordement_gaz = $request['raccordement_gaz_terrain'];
            $Biendetail->terrain_raccordement_electricite = $request['raccordement_electricite_terrain'];
            $Biendetail->terrain_raccordement_telephone = $request['raccordement_telephone_terrain'];
            $Biendetail->equipement_format = $request['format_equipement'];
            $Biendetail->equipement_type = $request['type_equipement'];
            $Biendetail->equipement_energie = $request['energie_equipement'];
            $Biendetail->equipement_ascenseur = $request['ascenseur_equipement'];
            $Biendetail->equipement_acces_handicape = $request['acces_handicape_equipement'];
            $Biendetail->equipement_climatisation = $request['climatisation_equipement'];
            $Biendetail->equipement_climatisation_specification = $request['climatisation_specification_equipement'];
            $Biendetail->equipement_eau_alimentation = $request['eau_alimentation_equipement'];
            $Biendetail->equipement_eau_assainissement = $request['eau_assainissement_equipement'];
            $Biendetail->equipement_eau_chaude_distribution = $request['eau_chaude_distribution_equipement'];
            $Biendetail->equipement_eau_chaude_energie = $request['eau_chaude_energie_equipement'];
            $Biendetail->equipement_cheminee = $request['cheminee_equipement'];
            $Biendetail->equipement_arrosage = $request['arrosage_automatique_equipement'];
            $Biendetail->equipement_barbecue = $request['barbecue_equipement'];
            $Biendetail->equipement_tennis = $request['tennis_equipement'];
            $Biendetail->equipement_local_a_velo = $request['local_a_velo_equipement'];
            $Biendetail->equipement_volet_electrique = $request['volet_electrique_equipement'];
            $Biendetail->equipement_gardien = $request['gardien_equipement'];
            $Biendetail->equipement_double_vitrage = $request['double_vitrage_equipement'];
            $Biendetail->equipement_triple_vitrage = $request['triple_vitrage_equipement'];
            $Biendetail->equipement_cable = $request['cable_equipement'];
            $Biendetail->equipement_securite_porte_blinde = $request['securite_porte_blinde_equipement'];
            $Biendetail->equipement_securite_interphone = $request['securite_interphone_equipement'];
            $Biendetail->equipement_securite_visiophone = $request['securite_visiophone_equipement'];
            $Biendetail->equipement_securite_alarme = $request['securite_alarme_equipement'];
            $Biendetail->equipement_securite_digicode = $request['securite_digicode_equipement'];
            $Biendetail->equipement_securite_detecteur_de_fumee = $request['securite_detecteur_de_fumee_equipement'];
            $Biendetail->equipement_portail_electrique = $request['portail_electrique_equipement'];
            $Biendetail->equipement_cuisine_ete = $request['cuisine_ete_equipement'];
            $Biendetail->diagnostic_annee_construction = $request['annee_construction_diagnostic'];
            $Biendetail->diagnostic_dpe_bien_soumi = $request['dpe_bien_soumi_diagnostic'];
            $Biendetail->diagnostic_dpe_vierge = $request['dpe_vierge_diagnostic'];
            $Biendetail->diagnostic_dpe_consommation = $request['dpe_consommation_diagnostic'];
            $Biendetail->diagnostic_dpe_ges = $request['dpe_ges_diagnostic'];
            $Biendetail->diagnostic_dpe_date = $request['dpe_diagnostic'];
            $Biendetail->diagnostic_etat_exterieur = $request['etat_exterieur_diagnostic'];
            $Biendetail->diagnostic_etat_interieur = $request['etat_interieur_diagnostic'];
            $Biendetail->diagnostic_surface_annexe = $request['surface_annexe_diagnostic'];
            $Biendetail->diagnostic_etat_parasitaire = $request['etat_parasitaire_diagnostic'];
            $Biendetail->diagnostic_etat_parasitaire_date = $request['etat_parasitaire_date_diagnostic'];
            $Biendetail->diagnostic_etat_parasitaire_commentaire = $request['etat_parasitaire_commentaire_diagnostic'];
            $Biendetail->diagnostic_amiante = $request['amiante_diagnostic'];
            $Biendetail->diagnostic_amiante_date = $request['amiante_date_diagnostic'];
            $Biendetail->diagnostic_amiante_commentaire = $request['amiante_commentaire_diagnostic'];
            $Biendetail->diagnostic_electrique = $request['electrique_diagnostic'];
            $Biendetail->diagnostic_electrique_date = $request['electrique_date_diagnostic'];
            $Biendetail->diagnostic_electrique_commentaire = $request['electrique_commentaire_diagnostic'];
            $Biendetail->diagnostic_loi_carrez = $request['loi_carrez_diagnostic'];
            $Biendetail->diagnostic_loi_carrez_date = $request['loi_carrez_date_diagnostic'];
            $Biendetail->diagnostic_loi_carrez_commentaire = $request['loi_carrez_commentaire_diagnostic'];
            $Biendetail->diagnostic_risque_nat = $request['risque_nat_diagnostic'];
            $Biendetail->diagnostic_risque_nat_date = $request['risque_nat_date_diagnostic'];
            $Biendetail->diagnostic_risque_nat_commentaire = $request['risque_nat_commentaire_diagnostic'];
            $Biendetail->diagnostic_plomb = $request['plomb_diagnostic'];
            $Biendetail->diagnostic_plomb_date = $request['plomb_date_diagnostic'];
            $Biendetail->diagnostic_plomb_commentaire = $request['plomb_commentaire_diagnostic'];
            $Biendetail->diagnostic_gaz = $request['gaz_diagnostic'];
            $Biendetail->diagnostic_gaz_date = $request['gaz_date_diagnostic'];
            $Biendetail->diagnostic_gaz_commentaire = $request['gaz_commentaire_diagnostic'];
            $Biendetail->diagnostic_assainissement = $request['assainissement_diagnostic'];
            $Biendetail->diagnostic_assainissement_date = $request['assainissement_date_diagnostic'];
            $Biendetail->diagnostic_assainissement_commentaire = $request['assainissement_commentaire_diagnostic'];
            
    
        }
        elseif($request["type_update"] == "prix"){
            $Bien->prix_public = $request['prix_public'];
            $Bien->prix_prive = $request['prix_prive'];
            $Bien->loyer = $request['loyer'];
            $Bien->complement_loyer = $request['complement_loyer'];
            $Bien->honoraire_acquereur = $request['honoraire_acquereur_info_fin'];
            $Bien->honoraire_vendeur = $request['honoraire_vendeur_info_fin'];
            $Bien->estimation_valeur = $request['estimation_valeur_info_fin'];
            $Bien->estimation_date = $request['estimation_date_info_fin'];
            $Bien->viager_prix_bouquet = $request['viager_valeur_info_fin'];
            $Bien->viager_rente_mensuelle = $request['viager_rente_mensuelle_info_fin'];
            $Bien->travaux_a_prevoir = $request['travaux_a_prevoir_info_fin'];
            $Bien->depot_garanti = $request['depot_garanti_info_fin'];
            $Bien->taxe_habitation = $request['taxe_habitation_info_fin'];
            $Bien->taxe_fonciere = $request['taxe_fonciere_info_fin'];
            $Bien->charge_mensuelle_total = $request['charge_mensuelle_total_info_fin'];
            $Bien->charge_mensuelle_info = $request['charge_mensuelle_info_info_fin'];
            $Biendetail->dossier_dispo_numero = $request['numero_dossier_dispo'];
            $Biendetail->dossier_dispo_dossier_cree_le = $request['dossier_cree_le_dossier_dispo'];
            $Biendetail->dossier_dispo_disponibilite_immediate = $request['disponibilite_immediate_dossier_dispo'];
            $Biendetail->dossier_dispo_disponible_le = $request['disponible_le_dossier_dispo'];
            $Biendetail->dossier_dispo_liberation_le = $request['liberation_le_dossier_dispo'];
    
        }
        elseif($request["type_update"] == "secteur"){
            
            $Bien->pays_annonce = $request['pays_annonce_secteur'];
            $Bien->adresse_bien = $request['adresse_bien_secteur'];
            $Bien->complement_adresse = $request['complement_adresse_secteur'];
            $Bien->quartier = $request['quartier_secteur'];
            $Bien->secteur = $request['secteur_secteur'];
            $Bien->immeuble_batiment = $request['immeuble_batiment_secteur'];
            $Bien->transport_a_proximite = $request['transport_a_proximite_secteur'];
            $Bien->proximite = $request['proximite_secteur'];
            $Bien->environnement = $request['environnement_secteur'];
    
        }
    
        // Sauvegarde du bien

        $Biendetail->update();
        $Bien->update();
       
    
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
