<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bien;
use App\Photosbien;
use App\Diffusion;
use App\Passerelle;
use App\User;

class ExportdiffusionController extends Controller
{
    
    private $passerelles_path;

	public function __construct()	{

        // chemin des fichiers d'annonces
        $this->passerelles_path = public_path('passerelles');
    }
    
    /** Création de la variable contenant Les users, et leurs diffusion par passerelle
    * @author jean-philippe
    * @param  string $ref_passerelle
    * @return \Illuminate\Http\Response
    **/
    public function datas($ref_passerelle){
        
        // on réccupère la passerelle
        $passerelle = Passerelle::where('reference',$ref_passerelle)->first();



        // on réccupère la date d'aujourd'hui à 23:00 pour les diffusions planifiées
        $today = time();
        $today = strtotime(gmdate("Y-m-d", $today).'23:00:00');

        // on reccupère les biens planifié d'aujourd'hui pour exclure leur diffusion auto
        $biens_id_plan = array();
        $biens_plans = Diffusion::where([ ['type','planifie'], ['passerelle_id',$passerelle->id], ['date', $today ] ])->select('bien_id')->get()->toArray();
        foreach ($biens_plans as $bien_plan ) {
           $biens_id_plan[] = $bien_plan['bien_id'];
        }
        // on réccupère les diffusions auto qui ne sont pas planifiées today et les diffusions planifiées de today
        $diffusions_auto = Diffusion::where( 'type','automatique')->whereNotIn('bien_id',$biens_id_plan)->get();
        $diffusions_plan = Diffusion::where([ ['type','planifie'], ['passerelle_id',$passerelle->id], ['date', $today ] ])->get();
        
        // Liste des commerciaux
        $users = User::whereIn('role',['admin','commercial'])->get();
        // dd($users);

        $globals = array();
        $users_diffusions = array();
        
        //construction du tableau user|diffusion_auto---diffusion_plan
        foreach ($users as $user) {
            
                    $user_diffusion_auto = array();
                    $user_diffusion_plan = array();
                    $tmp = array();
                    // on reccupère les diffusions auto du user
                    foreach ($diffusions_auto as $diff_auto) {
                        if($user->id === $diff_auto->bien->user->id){
                            $user_diffusion_auto[] = $diff_auto;
                            
                        }
                    }

                    // on reccupère les diffusions plani du user
                    foreach ($diffusions_plan as $diff_plan) {
                        if($user->id === $diff_plan->bien->user->id){
                            $user_diffusion_plan[] = $diff_plan; 
                        }
                    }

                    sizeof( $user_diffusion_auto) > 0 ?  $tmp['auto'] = $user_diffusion_auto : $tmp['auto'] = array() ;
                    sizeof( $user_diffusion_plan) > 0 ?  $tmp['plan'] = $user_diffusion_plan : $tmp['plan'] = array();
                    // on constructuit le tableau si le user a au moins une diffusion prévue sur cette passerelle
                    if($tmp["auto"] != null || $tmp["plan"] != null){
                        $users_diffusions["user"] = $user;
                        $users_diffusions["diffusion"] = $tmp;
                        $globals[] = $users_diffusions;
                    }

                    
                }
                // on retourne le tableau 
                return $globals;

    }
	
/**
* @author jean-philippe
* @param  App\Bienphoto
* @return \Illuminate\Http\Response
**/
	public function add_element($xw,$tag,$value){
		
		xmlwriter_start_element($xw, $tag);
			xmlwriter_text($xw, $value);
		xmlwriter_end_element($xw);
	}
	
	
    public function exportPrincipal(){
		
	
    }
    
    public function exportLogicImmo(){

        $exports = $this->datas("logicimmo");

        // dd($exports);
        
        $xw = xmlwriter_open_memory();
        xmlwriter_set_indent($xw, 1);
        $res = xmlwriter_set_indent_string($xw, '    ');
        
           
        xmlwriter_start_document($xw, '1.0', 'UTF-8');   
            xmlwriter_start_element($xw,"biens");
                xmlwriter_start_element($xw,"annonceur");
                    $this->add_element($xw,"numero_carte_pro","16012016000003526");
                    $this->add_element($xw,"bareme_honoraires_pdf","http://www.domaine.com/bareme_honoraires.pdf?maj=13042017_110217");
                xmlwriter_end_element($xw);

                // diffusions automatique
            foreach ($exports as $export) {
                
                $diffs_autos = $export['diffusion']['auto'];
                $diffs_plans = $export['diffusion']['plan'];
                
              
                $user = $export['user'];

                foreach ($diffs_autos as $diff_auto) {

                    $bien = $diff_auto->bien;
                    
                    
                    $biendetail = $bien->biendetail;
                //Biens à la vente
                
                                
                xmlwriter_start_element($xw,"bien");
                    $this->add_element($xw,"agence_nom",$user->nom);
                    $this->add_element($xw,"agence_tel","748956321");
                    $this->add_element($xw,"agence_tel2","0252526545");
                    $this->add_element($xw,"agence_mail",$user->email);
                    $this->add_element($xw,"agence_mobile","052854714");
                    $this->add_element($xw,"agence_fax","16012016000003526");
                    $this->add_element($xw,"agence_adresse","adresse 05");
                    $this->add_element($xw,"agence_postal","ag_pos");
                    $this->add_element($xw,"agence_postal_insee","xxxxxxxx");
                    $this->add_element($xw,"agence_ville","agence_ville");
                    $this->add_element($xw,"agence_pays","agence_pays");
                    $this->add_element($xw,"code_passerelle","code_passerelle");
                    $this->add_element($xw,"reference_logiciel","reference_logiciel");
                    $this->add_element($xw,"reference_client","reference_client");
                    $this->add_element($xw,"numero_mandat","numero_mandat");
                    $this->add_element($xw,"type_mandat","type_mandat");
                    $this->add_element($xw,"agence_tel_a_afficher","agence_tel_a_afficher");
                    $this->add_element($xw,"agence_mail_a_afficher","agence_mail_a_afficher");
                    $this->add_element($xw,"negociateur_nom","negociateur_nom");
                    $this->add_element($xw,"negociateur_tel","negociateur_tel");
                    $this->add_element($xw,"negociateur_mail","negociateur_mail");
                    
                    xmlwriter_start_element($xw,"photos");

                    foreach ($bien->photosbiens as $photo) {
                        xmlwriter_start_element($xw,"photo");
                            $this->add_element($xw,"titre","");
                            $this->add_element($xw,"url",$this->passerelles_path.'/'.$photo->filename);
                        xmlwriter_end_element($xw);
                    }
                    xmlwriter_end_element($xw);


                    $this->add_element($xw,"type_transaction",$bien->type_offre);
                    $this->add_element($xw,"type_bien",$bien->type_bien);
                    $this->add_element($xw,"publication_web","");
                    xmlwriter_start_element($xw,"publication_liste");
                        $this->add_element($xw,"site","");
                        $this->add_element($xw,"site","");
                        $this->add_element($xw,"site","");
                    xmlwriter_end_element($xw);
                    xmlwriter_start_element($xw,"titres");
                        $this->add_element($xw,"titre_web_fr",$bien->titre_annonce);
                        $this->add_element($xw,"titre_print_fr",$bien->titre_annonce);
                        $this->add_element($xw,"titre_web_nl","");
                        $this->add_element($xw,"titre_print_nl","");
                        $this->add_element($xw,"titre_web_en","");
                        $this->add_element($xw,"titre_print_en","");
                        $this->add_element($xw,"titre_web_de","");
                        $this->add_element($xw,"titre_print_de","");
                        $this->add_element($xw,"titre_web_it","");
                        $this->add_element($xw,"titre_print_it","");
                        $this->add_element($xw,"titre_web_pt","");
                        $this->add_element($xw,"titre_print_pt","");
                        $this->add_element($xw,"titre_web_sp","");
                        $this->add_element($xw,"titre_print_sp","");
                        $this->add_element($xw,"titre_web_ru","");
                        $this->add_element($xw,"titre_print_ru","");
                    xmlwriter_end_element($xw);
                    xmlwriter_start_element($xw,"descriptions");
                        $this->add_element($xw,"descriptif_web_fr",$bien->description_annonce);
                        $this->add_element($xw,"descriptif_print_fr",$bien->description_annonce);
                        $this->add_element($xw,"descriptif_web_nl","");
                        $this->add_element($xw,"descriptif_print_nl","");
                        $this->add_element($xw,"descriptif_web_en","");
                        $this->add_element($xw,"descriptif_print_en","");
                        $this->add_element($xw,"descriptif_web_de","");
                        $this->add_element($xw,"descriptif_print_de","");
                        $this->add_element($xw,"descriptif_web_it","");
                        $this->add_element($xw,"descriptif_print_it","");
                        $this->add_element($xw,"descriptif_web_pt","");
                        $this->add_element($xw,"descriptif_print_pt","");
                        $this->add_element($xw,"descriptif_web_sp","");
                        $this->add_element($xw,"descriptif_print_sp","");
                        $this->add_element($xw,"descriptif_web_ru","");
                        $this->add_element($xw,"descriptif_print_ru","");
                    xmlwriter_end_element($xw);
                    $this->add_element($xw,"adresse",$bien->adresse_bien);
                    $this->add_element($xw,"adresse_approximative","");
                    $this->add_element($xw,"code_postal_a_afficher",$bien->codepostal);
                    $this->add_element($xw,"code_postal_reel",$bien->codepostal);
                    $this->add_element($xw,"code_postal_insee","");
                    $this->add_element($xw,"code_postal_approximatif","");
                    $this->add_element($xw,"commune_reel",$bien->ville);
                    $this->add_element($xw,"commune_a_afficher",$bien->ville);
                    $this->add_element($xw,"commune_approximative","");
                    $this->add_element($xw,"secteur",$bien->secteur);
                    $this->add_element($xw,"pays",$bien->pays);
                    $this->add_element($xw,"is_confidence_commune","");
                    $this->add_element($xw,"gps_longitude","");
                    $this->add_element($xw,"gps_longitude_approximative","");
                    $this->add_element($xw,"gps_latitude","");
                    $this->add_element($xw,"gps_latitude","");
                    $this->add_element($xw,"gps_latitude_approximative","");
                    $this->add_element($xw,"gps_rayon","");
                    $this->add_element($xw,"proximite_liste",$bien->proximite);
                    $this->add_element($xw,"proximite_gare","");
                    $this->add_element($xw,"proximite_metro","");
                    $this->add_element($xw,"proximite_commerce","");
                    $this->add_element($xw,"proximite_bus","");
                    $this->add_element($xw,"proximite_tourisme","");
                    $this->add_element($xw,"proximite_tourisme","");
                    $this->add_element($xw,"proximite_culture","");
                    $this->add_element($xw,"proximite_culture","");
                    $this->add_element($xw,"proximite_ecole","");
                    $this->add_element($xw,"proximite_espace_vert","");
                    $this->add_element($xw,"prix",$bien->prix_public);
                    $this->add_element($xw,"depot_garantie",$bien->depot_garanti);
                    $this->add_element($xw,"montant_charge","");
                    $this->add_element($xw,"montant_charges_copropriete","");
                    $this->add_element($xw,"is_en_procedure","");
                    $this->add_element($xw,"evolution_procedure","");
                    if($bien->honoraire_vendeur == "Oui" && $bien->honoraire_acquereur == "Non"){
                        $honoraire = "Vendeur";
                    }elseif($bien->honoraire_vendeur == "Non" && $bien->honoraire_acquereur == "Oui"){
                        $honoraire = "Acheteur";
                    }else{ $honoraire = "Acheteur et vendeur" ;}
                    $this->add_element($xw,"frais_agence_a_la_charge_de", $honoraire);
                    $this->add_element($xw,"is_bien_en_copropriete",($biendetail->copropriete_bien_en == "Non") ? false : true );
                    $this->add_element($xw,"nb_lots_copropriete",$biendetail->copropriete_nombre_lot);
                    $this->add_element($xw,"numero_du_lot_en_copropriete",$biendetail->copropriete_numero_lot);
                    $this->add_element($xw,"statut_syndicat",$biendetail->copropriete_statut_syndic);	
                    $this->add_element($xw,"montant_taxe","");
                    $this->add_element($xw,"devise","");
                    $this->add_element($xw,"is_confidence_prix","");
                    $this->add_element($xw,"dpe_bilan","");
                    $this->add_element($xw,"dpe_valeur",$biendetail->diagnostic_dpe_consommation);
                    $this->add_element($xw,"dpe_date",$biendetail->diagnostic_dpe_date);
                    $this->add_element($xw,"ges_bilan","");
                    $this->add_element($xw,"ges_valeur",$biendetail->diagnostic_dpe_ges);
                    $this->add_element($xw,"ges_date",$biendetail->diagnostic_dpe_date);
                    $this->add_element($xw,"is_batiment_basse_conso","");
                    $this->add_element($xw,"type_chauffage","");
                    $this->add_element($xw,"nature_chauffage","");
                    $this->add_element($xw,"type_cuisine",$biendetail->agen_inter_cuisine_type);
                    $this->add_element($xw,"nb_pieces",$bien->nombre_piece);
                    $this->add_element($xw,"nb_chambres",$bien->nombre_chambre);
                    $this->add_element($xw,"nb_etages","");
                    $this->add_element($xw,"nb_salle_d_eau",$biendetail->agen_inter_nb_salle_eau);
                    $this->add_element($xw,"nb_salle_de_bain",$biendetail->agen_inter_nb_salle_bain);
                    $this->add_element($xw,"nb_garages",$biendetail->agen_exter_nb_garage);
                    $this->add_element($xw,"nb_parkings","");
                    $this->add_element($xw,"nb_parkings_exterieurs","");
                    $this->add_element($xw,"nb_parkings_interieurs","");
                    $this->add_element($xw,"nb_tennis","");
                    $this->add_element($xw,"nb_wc",$biendetail->agen_inter_nb_wc);
                    $this->add_element($xw,"surface_bien",$bien->surface);
                    $this->add_element($xw,"surface_sejour","");
                    $this->add_element($xw,"surface_terrain",$bien->surface_terrain);
                    $this->add_element($xw,"surface_terrasse",$biendetail->agen_exter_surface_terrasse);
                    $this->add_element($xw,"is_duplex","");
                    $this->add_element($xw,"is_investissement","");
                    $this->add_element($xw,"is_recent","");
                    $this->add_element($xw,"is_refait","");
                    $this->add_element($xw,"is_travaux","");
                    $this->add_element($xw,"is_acces_handicapes","");
                    $this->add_element($xw,"is_terrain_constructible",($biendetail->terrain_constructible == "Non") ? false : true );
                    $this->add_element($xw,"has_ascenseur","");
                    $this->add_element($xw,"has_balcon","");
                    $this->add_element($xw,"has_terrasse","");
                    $this->add_element($xw,"has_climatisation","");
                    $this->add_element($xw,"has_piscine","");
                    $this->add_element($xw,"has_cabletv","");
                    $this->add_element($xw,"has_cave","");
                    $this->add_element($xw,"has_cellier","");
                    $this->add_element($xw,"has_garage","");
                    $this->add_element($xw,"has_box","");
                    $this->add_element($xw,"has_grenier","");
                    $this->add_element($xw,"has_jardin","");
                    $this->add_element($xw,"has_veranda","");
                    $this->add_element($xw,"annee_construction",$biendetail->diagnostic_annee_construction);
                    $this->add_element($xw,"date_de_livraison","");
                    $this->add_element($xw,"liste_annexes","");
                    $this->add_element($xw,"url_visite_virtuelle","");
                    $this->add_element($xw,"url_bien_internet","");
                    $this->add_element($xw,"pourcentage_honoraires_acquereur","");
                    $this->add_element($xw,"prix_sans_honoraires","");

                if($bien->type_offre === "location"){   

                    $this->add_element($xw,"montant_frais_agence","");
                    $this->add_element($xw,"montant_honoraires_etat_lieux","");
                    $this->add_element($xw,"type_regularisation_charges","");
                    $this->add_element($xw,"mode_regularisation_charges","");
                    $this->add_element($xw,"montant_complement_loyer",$bien->complement_loyer);
                    $this->add_element($xw,"frequence_reglement_loyer","Mensuel");
                    $this->add_element($xw,"frequence_reglement_charges","Mensuel");
                    $this->add_element($xw,"echeance_reglement_loyer","A échoir");
                    $this->add_element($xw,"echeance_reglement_charges","échoir");
                }
                xmlwriter_end_element($xw);
            }
            
     

            // diffusion planifiée
            $user = $export['user'];
            foreach ($diffs_plans as $diff_plan) {

                $bien = $diff_plan->bien;
                
                
                $biendetail = $bien->biendetail;
                $annonce = $diff_plan->annonce;
                //Biens à la vente
                                
                xmlwriter_start_element($xw,"bien");
                    $this->add_element($xw,"agence_nom",$user->nom);
                    $this->add_element($xw,"agence_tel","748956321");
                    $this->add_element($xw,"agence_tel2","0252526545");
                    $this->add_element($xw,"agence_mail",$user->email);
                    $this->add_element($xw,"agence_mobile","052854714");
                    $this->add_element($xw,"agence_fax","16012016000003526");
                    $this->add_element($xw,"agence_adresse","adresse 05");
                    $this->add_element($xw,"agence_postal","ag_pos");
                    $this->add_element($xw,"agence_postal_insee","xxxxxxxx");
                    $this->add_element($xw,"agence_ville","agence_ville");
                    $this->add_element($xw,"agence_pays","agence_pays");
                    $this->add_element($xw,"code_passerelle","code_passerelle");
                    $this->add_element($xw,"reference_logiciel","reference_logiciel");
                    $this->add_element($xw,"reference_client","reference_client");
                    $this->add_element($xw,"numero_mandat","numero_mandat");
                    $this->add_element($xw,"type_mandat","type_mandat");
                    $this->add_element($xw,"agence_tel_a_afficher","agence_tel_a_afficher");
                    $this->add_element($xw,"agence_mail_a_afficher","agence_mail_a_afficher");
                    $this->add_element($xw,"negociateur_nom","negociateur_nom");
                    $this->add_element($xw,"negociateur_tel","negociateur_tel");
                    $this->add_element($xw,"negociateur_mail","negociateur_mail");
                    
                    xmlwriter_start_element($xw,"photos");

                    foreach ($bien->photosbiens as $photo) {
                        xmlwriter_start_element($xw,"photo");
                            $this->add_element($xw,"titre","");
                            $this->add_element($xw,"url",$this->passerelles_path.'/'.$photo->filename);
                        xmlwriter_end_element($xw);
                    }
                    xmlwriter_end_element($xw);


                    $this->add_element($xw,"type_transaction",$bien->type_offre);
                    $this->add_element($xw,"type_bien",$bien->type_bien);
                    $this->add_element($xw,"publication_web","");
                    xmlwriter_start_element($xw,"publication_liste");
                        $this->add_element($xw,"site","");
                        $this->add_element($xw,"site","");
                        $this->add_element($xw,"site","");
                    xmlwriter_end_element($xw);
                    xmlwriter_start_element($xw,"titres");
                        $this->add_element($xw,"titre_web_fr",$annonce != null ? $annonce->titre:  $bien->titre_annonce);
                        $this->add_element($xw,"titre_print_fr",$annonce != null ? $annonce->titre:  $bien->titre_annonce);
                        $this->add_element($xw,"titre_web_nl","");
                        $this->add_element($xw,"titre_print_nl","");
                        $this->add_element($xw,"titre_web_en","");
                        $this->add_element($xw,"titre_print_en","");
                        $this->add_element($xw,"titre_web_de","");
                        $this->add_element($xw,"titre_print_de","");
                        $this->add_element($xw,"titre_web_it","");
                        $this->add_element($xw,"titre_print_it","");
                        $this->add_element($xw,"titre_web_pt","");
                        $this->add_element($xw,"titre_print_pt","");
                        $this->add_element($xw,"titre_web_sp","");
                        $this->add_element($xw,"titre_print_sp","");
                        $this->add_element($xw,"titre_web_ru","");
                        $this->add_element($xw,"titre_print_ru","");
                    xmlwriter_end_element($xw);
                    xmlwriter_start_element($xw,"descriptions");
                        $this->add_element($xw,"descriptif_web_fr",$annonce != null ? $annonce->description : $bien->description_annonce);
                        $this->add_element($xw,"descriptif_print_fr",$annonce != null ? $annonce->description : $bien->description_annonce);
                        $this->add_element($xw,"descriptif_web_nl","");
                        $this->add_element($xw,"descriptif_print_nl","");
                        $this->add_element($xw,"descriptif_web_en","");
                        $this->add_element($xw,"descriptif_print_en","");
                        $this->add_element($xw,"descriptif_web_de","");
                        $this->add_element($xw,"descriptif_print_de","");
                        $this->add_element($xw,"descriptif_web_it","");
                        $this->add_element($xw,"descriptif_print_it","");
                        $this->add_element($xw,"descriptif_web_pt","");
                        $this->add_element($xw,"descriptif_print_pt","");
                        $this->add_element($xw,"descriptif_web_sp","");
                        $this->add_element($xw,"descriptif_print_sp","");
                        $this->add_element($xw,"descriptif_web_ru","");
                        $this->add_element($xw,"descriptif_print_ru","");
                    xmlwriter_end_element($xw);
                    $this->add_element($xw,"adresse",$bien->adresse_bien);
                    $this->add_element($xw,"adresse_approximative","");
                    $this->add_element($xw,"code_postal_a_afficher",$bien->codepostal);
                    $this->add_element($xw,"code_postal_reel",$bien->codepostal);
                    $this->add_element($xw,"code_postal_insee","");
                    $this->add_element($xw,"code_postal_approximatif","");
                    $this->add_element($xw,"commune_reel",$bien->ville);
                    $this->add_element($xw,"commune_a_afficher",$bien->ville);
                    $this->add_element($xw,"commune_approximative","");
                    $this->add_element($xw,"secteur",$bien->secteur);
                    $this->add_element($xw,"pays",$bien->pays);
                    $this->add_element($xw,"is_confidence_commune","");
                    $this->add_element($xw,"gps_longitude","");
                    $this->add_element($xw,"gps_longitude_approximative","");
                    $this->add_element($xw,"gps_latitude","");
                    $this->add_element($xw,"gps_latitude","");
                    $this->add_element($xw,"gps_latitude_approximative","");
                    $this->add_element($xw,"gps_rayon","");
                    $this->add_element($xw,"proximite_liste",$bien->proximite);
                    $this->add_element($xw,"proximite_gare","");
                    $this->add_element($xw,"proximite_metro","");
                    $this->add_element($xw,"proximite_commerce","");
                    $this->add_element($xw,"proximite_bus","");
                    $this->add_element($xw,"proximite_tourisme","");
                    $this->add_element($xw,"proximite_tourisme","");
                    $this->add_element($xw,"proximite_culture","");
                    $this->add_element($xw,"proximite_culture","");
                    $this->add_element($xw,"proximite_ecole","");
                    $this->add_element($xw,"proximite_espace_vert","");
                    $this->add_element($xw,"prix",$annonce != null ? $annonce->prix : $bien->prix_public);
                    $this->add_element($xw,"depot_garantie",$bien->depot_garanti);
                    $this->add_element($xw,"montant_charge","");
                    $this->add_element($xw,"montant_charges_copropriete","");
                    $this->add_element($xw,"is_en_procedure","");
                    $this->add_element($xw,"evolution_procedure","");
                    if($bien->honoraire_vendeur == "Oui" && $bien->honoraire_acquereur == "Non"){
                        $honoraire = "Vendeur";
                    }elseif($bien->honoraire_vendeur == "Non" && $bien->honoraire_acquereur == "Oui"){
                        $honoraire = "Acheteur";
                    }else{ $honoraire = "Acheteur et vendeur" ;}
                    $this->add_element($xw,"frais_agence_a_la_charge_de", $honoraire);
                    $this->add_element($xw,"is_bien_en_copropriete",($biendetail->copropriete_bien_en == "Non") ? false : true );
                    $this->add_element($xw,"nb_lots_copropriete",$biendetail->copropriete_nombre_lot);
                    $this->add_element($xw,"numero_du_lot_en_copropriete",$biendetail->copropriete_numero_lot);
                    $this->add_element($xw,"statut_syndicat",$biendetail->copropriete_statut_syndic);	
                    $this->add_element($xw,"montant_taxe","");
                    $this->add_element($xw,"devise","");
                    $this->add_element($xw,"is_confidence_prix","");
                    $this->add_element($xw,"dpe_bilan","");
                    $this->add_element($xw,"dpe_valeur",$biendetail->diagnostic_dpe_consommation);
                    $this->add_element($xw,"dpe_date",$biendetail->diagnostic_dpe_date);
                    $this->add_element($xw,"ges_bilan","");
                    $this->add_element($xw,"ges_valeur",$biendetail->diagnostic_dpe_ges);
                    $this->add_element($xw,"ges_date",$biendetail->diagnostic_dpe_date);
                    $this->add_element($xw,"is_batiment_basse_conso","");
                    $this->add_element($xw,"type_chauffage","");
                    $this->add_element($xw,"nature_chauffage","");
                    $this->add_element($xw,"type_cuisine",$biendetail->agen_inter_cuisine_type);
                    $this->add_element($xw,"nb_pieces",$bien->nombre_piece);
                    $this->add_element($xw,"nb_chambres",$bien->nombre_chambre);
                    $this->add_element($xw,"nb_etages","");
                    $this->add_element($xw,"nb_salle_d_eau",$biendetail->agen_inter_nb_salle_eau);
                    $this->add_element($xw,"nb_salle_de_bain",$biendetail->agen_inter_nb_salle_bain);
                    $this->add_element($xw,"nb_garages",$biendetail->agen_exter_nb_garage);
                    $this->add_element($xw,"nb_parkings","");
                    $this->add_element($xw,"nb_parkings_exterieurs","");
                    $this->add_element($xw,"nb_parkings_interieurs","");
                    $this->add_element($xw,"nb_tennis","");
                    $this->add_element($xw,"nb_wc",$biendetail->agen_inter_nb_wc);
                    $this->add_element($xw,"surface_bien",$bien->surface);
                    $this->add_element($xw,"surface_sejour","");
                    $this->add_element($xw,"surface_terrain",$bien->surface_terrain);
                    $this->add_element($xw,"surface_terrasse",$biendetail->agen_exter_surface_terrasse);
                    $this->add_element($xw,"is_duplex","");
                    $this->add_element($xw,"is_investissement","");
                    $this->add_element($xw,"is_recent","");
                    $this->add_element($xw,"is_refait","");
                    $this->add_element($xw,"is_travaux","");
                    $this->add_element($xw,"is_acces_handicapes","");
                    $this->add_element($xw,"is_terrain_constructible",($biendetail->terrain_constructible == "Non") ? false : true );
                    $this->add_element($xw,"has_ascenseur","");
                    $this->add_element($xw,"has_balcon","");
                    $this->add_element($xw,"has_terrasse","");
                    $this->add_element($xw,"has_climatisation","");
                    $this->add_element($xw,"has_piscine","");
                    $this->add_element($xw,"has_cabletv","");
                    $this->add_element($xw,"has_cave","");
                    $this->add_element($xw,"has_cellier","");
                    $this->add_element($xw,"has_garage","");
                    $this->add_element($xw,"has_box","");
                    $this->add_element($xw,"has_grenier","");
                    $this->add_element($xw,"has_jardin","");
                    $this->add_element($xw,"has_veranda","");
                    $this->add_element($xw,"annee_construction",$biendetail->diagnostic_annee_construction);
                    $this->add_element($xw,"date_de_livraison","");
                    $this->add_element($xw,"liste_annexes","");
                    $this->add_element($xw,"url_visite_virtuelle","");
                    $this->add_element($xw,"url_bien_internet","");
                    $this->add_element($xw,"pourcentage_honoraires_acquereur","");
                    $this->add_element($xw,"prix_sans_honoraires","");

                if($bien->type_offre === "location"){   

                    $this->add_element($xw,"montant_frais_agence","");
                    $this->add_element($xw,"montant_honoraires_etat_lieux","");
                    $this->add_element($xw,"type_regularisation_charges","");
                    $this->add_element($xw,"mode_regularisation_charges","");
                    $this->add_element($xw,"montant_complement_loyer",$bien->complement_loyer);
                    $this->add_element($xw,"frequence_reglement_loyer","Mensuel");
                    $this->add_element($xw,"frequence_reglement_charges","Mensuel");
                    $this->add_element($xw,"echeance_reglement_loyer","A échoir");
                    $this->add_element($xw,"echeance_reglement_charges","échoir");
                }
                xmlwriter_end_element($xw);
            }
        }
            xmlwriter_end_element($xw);   
            //Fin  du document
        xmlwriter_end_document($xw);
    
    	file_put_contents ($this->passerelles_path.'/logicimmo.xml',xmlwriter_output_memory($xw));
       dd( xmlwriter_output_memory($xw) );
    }




/** Export sur cléMidi
* @author jean-philippe
* @param  App\Bienphoto
* @return \Illuminate\Http\Response
**/	
	public function exportCleMidi(){
        $xw = xmlwriter_open_memory();
        xmlwriter_set_indent($xw, 1);
        $res = xmlwriter_set_indent_string($xw, '    ');
        $exports = $this->datas("cledumidi");

    xmlwriter_start_document($xw, '1.0', 'UTF-8');   
        xmlwriter_start_element($xw,"Agence");

        // dd($exports);
        foreach ($exports as $export) {

            $diffs_autos = $export['diffusion']['auto'];
            $diffs_plans = $export['diffusion']['plan'];
            $user = $export['user'];
            // dd($exports);
            

        	xmlwriter_start_element($xw,"Client");
            
				xmlwriter_start_element($xw,"ClientDetails");
					$this->add_element($xw,"clientNom",$user->nom);
					$this->add_element($xw,"clientContact","");
					$this->add_element($xw,"clientContactEmail",$user->email);
					$this->add_element($xw,"clientTelephone","");
				xmlwriter_end_element($xw);
            
                xmlwriter_start_element($xw,"Annonces");

            //### Diffusion automatiques                
                foreach ($diffs_autos as $diff_auto) {

                    $bien = $diff_auto->bien;
                    
                    
                    $biendetail = $bien->biendetail;

					xmlwriter_start_element($xw,"Annonce");
					$this->add_element($xw,"referenceInterne","xxx");
					$this->add_element($xw,"referenceMandat","xxx");
					$this->add_element($xw,"departementNum","xxxxx");
					$this->add_element($xw,"codePostal", $bien->code_postal);
					$this->add_element($xw,"codeInsee","xxxxxxx");
                    $this->add_element($xw,"typeTransaction",$bien->type_offre);
                    if($bien->honoraire_vendeur == "Oui" && $bien->honoraire_acquereur == "Non"){
                        $honoraire = 1;
                    }elseif($bien->honoraire_vendeur == "Non" && $bien->honoraire_acquereur == "Oui"){
                        $honoraire = 2;
                    }else{ $honoraire = 3 ;}
					$this->add_element($xw,"honoraires_charges",  $honoraire );
					$this->add_element($xw,"typeBien", $bien->type_bien);
					$this->add_element($xw,"typePrecis",$bien->type_type_bien);
					$this->add_element($xw,"prix",$bien->prix_public );
					$this->add_element($xw,"prix_net",$bien->prix_prive);
					$this->add_element($xw,"exclusivite","");
					$this->add_element($xw,"surface",$bien->surface);
					$this->add_element($xw,"surfaceTerrain",$bien->surface_terrain);
					$this->add_element($xw,"nombrePiece",$bien->nombre_piece );
					$this->add_element($xw,"nombreEtages","");
					$this->add_element($xw,"niveauEtage","");
					$this->add_element($xw,"nombreChambre",$bien->nombre_chambre);
					$this->add_element($xw,"NombreSalleDeBain",$biendetail->agen_inter_nb_salle_bain );
					$this->add_element($xw,"nombreSalleDeau",$biendetail->agen_inter_nb_salle_eau );
					$this->add_element($xw,"ascenseur","");
					$this->add_element($xw,"accesHandicape",$biendetail->equipement_acces_handicape == "Oui" ? true : false);
					$this->add_element($xw,"surfaceBalcon",$biendetail->agen_exter_surface_balcon);
					$this->add_element($xw,"nombreBalcon",$biendetail->agen_exter_nb_balcon );
					$this->add_element($xw,"nombreTerrasse",$biendetail->agen_exter_nb_terrasse);
					$this->add_element($xw,"surfaceTerrasse",$biendetail->agen_exter_surface_terrasse);
					$this->add_element($xw,"piscine","");
					$this->add_element($xw,"cuisine","");
					$this->add_element($xw,"garage","");
					$this->add_element($xw,"parking","");
					xmlwriter_start_element($xw,"dpe");
						$this->add_element($xw,"ges",$biendetail->diagnostic_dpe_ges );
						$this->add_element($xw,"bges","");
						$this->add_element($xw,"ce",$biendetail->diagnostic_dpe_consommation);
						$this->add_element($xw,"bce","");
					xmlwriter_end_element($xw);
					$this->add_element($xw,"titre",$bien->titre_annonce);
					$this->add_element($xw,"descriptiff",$bien->description_annonce);
					$this->add_element($xw,"descriptif_en","");
                    $this->add_element($xw,"descriptif_de","");					
                    xmlwriter_start_element($xw,"images");
                    foreach ($bien->photosbiens as $photo) {
                        xmlwriter_start_element($xw,"image");
                            xmlwriter_start_attribute($xw,"number");                        
                                xmlwriter_text($xw, $photo->image_position);
                            xmlwriter_end_attribute($xw);  
                            xmlwriter_text($xw, $this->passerelles_path.'/'.$photo->filename);
                        xmlwriter_end_element($xw);
                    }
                        
                    xmlwriter_end_element($xw); // fin element images

                    $this->add_element($xw,"datemaj",$diff_auto->modification_le);
                    xmlwriter_end_element($xw);	// Fin element annonce	
                }

                //### Diffusion planifiée                
                foreach ($diffs_plans as $diff_plan) {

                    $bien = $diff_plan->bien;
                    
                    
                    $biendetail = $bien->biendetail;

                    $annonce = $diff_plan->annonce;
					xmlwriter_start_element($xw,"Annonce");
					$this->add_element($xw,"referenceInterne","xxx");
					$this->add_element($xw,"referenceMandat","xxx");
					$this->add_element($xw,"departementNum","xxxxx");
					$this->add_element($xw,"codePostal", $bien->code_postal);
					$this->add_element($xw,"codeInsee","xxxxxxx");
                    $this->add_element($xw,"typeTransaction",$bien->type_offre);
                    if($bien->honoraire_vendeur == "Oui" && $bien->honoraire_acquereur == "Non"){
                        $honoraire = 1;
                    }elseif($bien->honoraire_vendeur == "Non" && $bien->honoraire_acquereur == "Oui"){
                        $honoraire = 2;
                    }else{ $honoraire = 3 ;}
					$this->add_element($xw,"honoraires_charges",  $honoraire );
					$this->add_element($xw,"typeBien", $bien->type_bien);
					$this->add_element($xw,"typePrecis",$bien->type_type_bien);
					$this->add_element($xw,"prix", $annonce != null ? $annonce->prix : $bien->prix_public);
					$this->add_element($xw,"prix_net",$bien->prix_prive);
					$this->add_element($xw,"exclusivite","");
					$this->add_element($xw,"surface",$bien->surface);
					$this->add_element($xw,"surfaceTerrain",$bien->surface_terrain);
					$this->add_element($xw,"nombrePiece",$bien->nombre_piece );
					$this->add_element($xw,"nombreEtages","");
					$this->add_element($xw,"niveauEtage","");
					$this->add_element($xw,"nombreChambre",$bien->nombre_chambre);
					$this->add_element($xw,"NombreSalleDeBain",$biendetail->agen_inter_nb_salle_bain );
					$this->add_element($xw,"nombreSalleDeau",$biendetail->agen_inter_nb_salle_eau );
					$this->add_element($xw,"ascenseur","");
					$this->add_element($xw,"accesHandicape",$biendetail->equipement_acces_handicape == "Oui" ? true : false);
					$this->add_element($xw,"surfaceBalcon",$biendetail->agen_exter_surface_balcon);
					$this->add_element($xw,"nombreBalcon",$biendetail->agen_exter_nb_balcon );
					$this->add_element($xw,"nombreTerrasse",$biendetail->agen_exter_nb_terrasse);
					$this->add_element($xw,"surfaceTerrasse",$biendetail->agen_exter_surface_terrasse);
					$this->add_element($xw,"piscine","");
					$this->add_element($xw,"cuisine","");
					$this->add_element($xw,"garage","");
					$this->add_element($xw,"parking","");
					xmlwriter_start_element($xw,"dpe");
						$this->add_element($xw,"ges",$biendetail->diagnostic_dpe_ges );
						$this->add_element($xw,"bges","");
						$this->add_element($xw,"ce",$biendetail->diagnostic_dpe_consommation);
						$this->add_element($xw,"bce","");
					xmlwriter_end_element($xw);
					$this->add_element($xw,"titre",$annonce != null ? $annonce->titre : $bien->titre_annonce);
					$this->add_element($xw,"descriptiff",$annonce != null ?  $annonce->description : $bien->description_annonce);
					$this->add_element($xw,"descriptif_en","");
                    $this->add_element($xw,"descriptif_de","");					
                    xmlwriter_start_element($xw,"images");
                    foreach ($bien->photosbiens as $photo) {
                        xmlwriter_start_element($xw,"image");
                            xmlwriter_start_attribute($xw,"number");                        
                                xmlwriter_text($xw, $photo->image_position);
                            xmlwriter_end_attribute($xw);  
                            xmlwriter_text($xw, $this->passerelles_path.'/'.$photo->filename);
                        xmlwriter_end_element($xw);
                    }
                        
                    xmlwriter_end_element($xw); // fin element images

                    $this->add_element($xw,"datemaj",$diff_plan->modification_le);
                    xmlwriter_end_element($xw);	// Fin element annonce	
                }



				xmlwriter_end_element($xw); // Fin element annonces
				
            xmlwriter_end_element($xw); // Fin element client
 
    }
        xmlwriter_end_element($xw);
        
        //Fin  du document
    xmlwriter_end_document($xw);
    	file_put_contents ($this->passerelles_path.'/clemidi.xml',xmlwriter_output_memory($xw));
       dd( xmlwriter_output_memory($xw) );
}
    
    
/** Export sur leboncoin
* @author jean-philippe
* @param  App\Bienphoto
* @return \Illuminate\Http\Response
**/	
	public function exportLeboncoin(){
	
        $xw = xmlwriter_open_memory();
        xmlwriter_set_indent($xw, 1);
        $res = xmlwriter_set_indent_string($xw, '    ');
        $exports = $this->datas("leboncoin");
        // dd($exports);
    xmlwriter_start_document($xw, '1.0', 'ISO-8859-15');   
        
     // diffusions automatique
     foreach ($exports as $export) {
                
        $diffs_autos = $export['diffusion']['auto'];
        $diffs_plans = $export['diffusion']['plan'];
        
        // dd($exports);
        $user = $export['user'];
        //Biens à la vente
        
        xmlwriter_start_element($xw,"client");
                xmlwriter_start_attribute($xw,"code");                        
                xmlwriter_text($xw, "ag350219");
                xmlwriter_end_attribute($xw);
				
				xmlwriter_start_element($xw,"coordonnees");
                    $this->add_element($xw,"raison_sociale","raison_sociale");
                    xmlwriter_start_element($xw,"adresse");
					    $this->add_element($xw,"voirie","xxxxx");					
					    $this->add_element($xw,"code_postal","xxxxx");					
					    $this->add_element($xw,"ville","xxxxx");					
                    xmlwriter_end_element($xw);	
                        
					$this->add_element($xw,"telephone","xxxxx");					
					$this->add_element($xw,"fax","xxx");					
					$this->add_element($xw,"email","xxxxx");					
					$this->add_element($xw,"web","xxxxx");					
                xmlwriter_end_element($xw);

                // ## diffusion automatique
                foreach ($diffs_autos as $diff_auto) {

                    $bien = $diff_auto->bien;
                    
                    
                    $biendetail = $bien->biendetail;

                xmlwriter_start_element($xw,"annonces");
                    xmlwriter_start_attribute($xw,"id");                        
                        xmlwriter_text($xw, 1453332);
                    xmlwriter_end_attribute($xw); 
                    $this->add_element($xw,"reference","refxxx");					
                    $this->add_element($xw,"titre",$bien->titre_description);					
                    $this->add_element($xw,"texte",$bien->description_description);					
                    $this->add_element($xw,"date_saisie",$bien->creation_le);					
                    $this->add_element($xw,"date_integration",$bien->modification_le);
                    
                    switch ($bien->type_bien) {
                        case 'maison':
                           $type_code = 1200;
                            break;
                        case 'appartement':
                            $type_code = 1100;
                            break;
                        case 'terrain':
                            $type_code = 1300;
                            break;
                        case 'autreType':
                            $type_code = 1190;
                            break;
                        default:
                            $type_code = 1190;
                            break;
                    }

                    xmlwriter_start_element($xw,"bien");
                        $this->add_element($xw,"code_type",$type_code);
                        $this->add_element($xw,"libelle_type", ucfirst($bien->type_bien) );
                        $this->add_element($xw,"code_postal", $bien->code_postal );
                        $this->add_element($xw,"ville", $bien->ville );
                        $this->add_element($xw,"code_insee",false);
                        $this->add_element($xw,"departement","");
                        $this->add_element($xw,"pays",$bien->pays);
                        $this->add_element($xw,"surface",$bien->surface);
                        $this->add_element($xw,"prestige","");
                        $this->add_element($xw,"lotissement","");
                    xmlwriter_end_element($xw);
                    xmlwriter_start_element($xw,"prestation");
                        $this->add_element($xw,"type",$bien->type_offre);
                        $this->add_element($xw,"mandat_type","xxxxxxxxxxxx");
                        $this->add_element($xw,"prix",$bien->prix_public);
                    xmlwriter_end_element($xw);	
                    xmlwriter_start_element($xw,"commerces");
                        $this->add_element($xw,"nb_salaries","");
                        $this->add_element($xw,"capital_societe","");
                        $this->add_element($xw,"regime_juridique","");
                        $this->add_element($xw,"benefices_industriels_et_commerciaux_annee_n","");
                        $this->add_element($xw,"benefices_industriels_et_commerciaux_annee_n_moins_1","");
                        $this->add_element($xw,"benefices_industriels_et_commerciaux_annee_n_moins_2","");
                        $this->add_element($xw,"valeur_comptable","");
                        $this->add_element($xw,"cashflow","");
                        $this->add_element($xw,"type_bail","");
                        $this->add_element($xw,"chiffre_d_affaires_annee_n","");
                        $this->add_element($xw,"chiffre_d_affaires_annee_n_moins_1","");
                        $this->add_element($xw,"chiffre_d_affaires_annee_n_moins_2","");
                        $this->add_element($xw,"rcs","");                        
                        $this->add_element($xw,"masse_salariale","");                        
                        $this->add_element($xw,"raison_sociale","");                        
                        $this->add_element($xw,"enseigne","");                        
                        $this->add_element($xw,"personnel","");                        
                        $this->add_element($xw,"surface_divisible_minimum","");                        
                        $this->add_element($xw,"ca","");                        
                        $this->add_element($xw,"ebe","");                        
                        $this->add_element($xw,"loto","");                        
                        $this->add_element($xw,"pmu","");                                          
                    xmlwriter_end_element($xw);
                    xmlwriter_start_element($xw,"photos");
                    foreach ($bien->photosbiens as $photo) {
                        $this->add_element($xw,"photo",$this->passerelles_path.'/'.$photo->filename);
                    }
                       
                    xmlwriter_end_element($xw);	
                    $this->add_element($xw,"contact_a_afficher","xxxxxxxxxxx");                                          
                    $this->add_element($xw,"email_a_afficher",$user->email);                                          
                    $this->add_element($xw,"telephone_a_afficher","xxxxxxxxxxx");                                          
                }

                // ## diffusion planifiée
                foreach ($diffs_plans as $diff_plan) {

                    $bien = $diff_plan->bien;
                    
                    
                    $biendetail = $bien->biendetail;
                    $annonce = $diff_plan->annonce;

                xmlwriter_start_element($xw,"annonces");
                    xmlwriter_start_attribute($xw,"id");                        
                        xmlwriter_text($xw, 1453332);
                    xmlwriter_end_attribute($xw); 
                    $this->add_element($xw,"reference","refxxx");					
                    $this->add_element($xw,"titre",$annonce != null ? $annonce->titre:  $bien->titre_annonce );					
                    $this->add_element($xw,"texte",$annonce != null ? $annonce->description:  $bien->description_annonce );					
                    $this->add_element($xw,"date_saisie",$bien->creation_le);					
                    $this->add_element($xw,"date_integration",$bien->modification_le);
                    
                    switch ($bien->type_bien) {
                        case 'maison':
                            $type_code = 1200;
                            break;
                        case 'appartement':
                            $type_code = 1100;
                            break;
                        case 'terrain':
                            $type_code = 1300;
                            break;
                        case 'autreType':
                            $type_code = 1190;
                            break;
                        default:
                            $type_code = 1190;
                            break;
                    }

                    xmlwriter_start_element($xw,"bien");
                        $this->add_element($xw,"code_type",$type_code);
                        $this->add_element($xw,"libelle_type", ucfirst($bien->type_bien) );
                        $this->add_element($xw,"code_postal", $bien->code_postal );
                        $this->add_element($xw,"ville", $bien->ville );
                        $this->add_element($xw,"code_insee",false);
                        $this->add_element($xw,"departement","");
                        $this->add_element($xw,"pays",$bien->pays);
                        $this->add_element($xw,"surface",$bien->surface);
                        $this->add_element($xw,"prestige","");
                        $this->add_element($xw,"lotissement","");
                    xmlwriter_end_element($xw);
                    xmlwriter_start_element($xw,"prestation");
                        $this->add_element($xw,"type",$bien->type_offre);
                        $this->add_element($xw,"mandat_type","xxxxxxxxxxxx");
                        $this->add_element($xw,"prix",$annonce != null ? $annonce->prix: $bien->prix_public);
                    xmlwriter_end_element($xw);	
                    xmlwriter_start_element($xw,"commerces");
                        $this->add_element($xw,"nb_salaries","");
                        $this->add_element($xw,"capital_societe","");
                        $this->add_element($xw,"regime_juridique","");
                        $this->add_element($xw,"benefices_industriels_et_commerciaux_annee_n","");
                        $this->add_element($xw,"benefices_industriels_et_commerciaux_annee_n_moins_1","");
                        $this->add_element($xw,"benefices_industriels_et_commerciaux_annee_n_moins_2","");
                        $this->add_element($xw,"valeur_comptable","");
                        $this->add_element($xw,"cashflow","");
                        $this->add_element($xw,"type_bail","");
                        $this->add_element($xw,"chiffre_d_affaires_annee_n","");
                        $this->add_element($xw,"chiffre_d_affaires_annee_n_moins_1","");
                        $this->add_element($xw,"chiffre_d_affaires_annee_n_moins_2","");
                        $this->add_element($xw,"rcs","");                        
                        $this->add_element($xw,"masse_salariale","");                        
                        $this->add_element($xw,"raison_sociale","");                        
                        $this->add_element($xw,"enseigne","");                        
                        $this->add_element($xw,"personnel","");                        
                        $this->add_element($xw,"surface_divisible_minimum","");                        
                        $this->add_element($xw,"ca","");                        
                        $this->add_element($xw,"ebe","");                        
                        $this->add_element($xw,"loto","");                        
                        $this->add_element($xw,"pmu","");                                          
                    xmlwriter_end_element($xw);
                    xmlwriter_start_element($xw,"photos");
                    foreach ($bien->photosbiens as $photo) {
                        $this->add_element($xw,"photo",$this->passerelles_path.'/'.$photo->filename);
                    }
                        
                    xmlwriter_end_element($xw);	
                    $this->add_element($xw,"contact_a_afficher","xxxxxxxxxxx");                                          
                    $this->add_element($xw,"email_a_afficher",$user->email);                                          
                    $this->add_element($xw,"telephone_a_afficher","xxxxxxxxxxx");                                          
                }
        xmlwriter_end_element($xw); //Fin element client
    }
        //Fin  du document
    xmlwriter_end_document($xw);
    	file_put_contents ($this->passerelles_path.'/leboncoin.xml',xmlwriter_output_memory($xw));
       dd( xmlwriter_output_memory($xw) );
	}


        
/** Export sur greenacres
* @author jean-philippe
* @param  App\Bienphoto
* @return \Illuminate\Http\Response
**/	
	public function exportGreenacres(){

        $xw = xmlwriter_open_memory();
        xmlwriter_set_indent($xw, 1);
        $res = xmlwriter_set_indent_string($xw, '    ');
        $exports = $this->datas("greenacres");
        // dd($exports);
    xmlwriter_start_document($xw, '1.0', 'utf-8');   
        xmlwriter_start_element($xw,"Envelope");
        xmlwriter_start_element($xw,"Body");
                
				
				xmlwriter_start_element($xw,"add_adverts");
                    
                    
                foreach ($exports as $export) {

                    $diffs_autos = $export['diffusion']['auto'];
                    $diffs_plans = $export['diffusion']['plan'];
                    
                    // dd($exports);
                    $user = $export['user'];
                    //### Diffusion automatique
                    foreach ($diffs_autos as $diff_auto) {
    
                        $bien = $diff_auto->bien;
                        
                        
                        $biendetail = $bien->biendetail;
                    //Biens à la vente
                    xmlwriter_start_element($xw,"advert");
                    
               
                    $this->add_element($xw,"account_id","xxxxxxxx");                                          
                    $this->add_element($xw,"reference","xxxxxxxx".$bien->mandat->numero); 
                    xmlwriter_start_element($xw,"publications");                   
                        xmlwriter_start_element($xw,"greenacres");                          
                            xmlwriter_text($xw, 1);
                        xmlwriter_end_element($xw);             
                    xmlwriter_end_element($xw);	
                    
                    $this->add_element($xw,"advert_type",$bien->type_offre == "vente" ? "properties" : "rentals");     
            
                    //  ['actif','offre','compromis', 'acte', 'cloture']                    
                    if($bien->statut == "actif" ){
                        $statut = "available";                        
                    }elseif($bien->statut == "compromis" ){
                        $statut = "under_offer";                        
                    }elseif($bien->statut == "acte" ){                        
                        $statut = $bien->type_offre == "vente" ? "sold" : "rented";                        
                    }  
                    elseif($bien->statut == "cloture" ){
                        $statut = "expired";                        
                    }  
                    $this->add_element($xw,"status",$statut);                                          
                    $this->add_element($xw,"price",$bien->prix_public);                                          
                    $this->add_element($xw,"currency","EUR");                                          
                    $this->add_element($xw,"has_included_fees",1);    
                    if($bien->honoraire_vendeur == "Oui" && $bien->honoraire_acquereur == "Non"){
                        $honoraire = 0;
                        $hono_valeur = $bien->taux_prix; 
                    }elseif($bien->honoraire_vendeur == "Non" && $bien->honoraire_acquereur == "Oui"){
                        $honoraire = 1;
                        $hono_valeur = $bien->taux_net; 
                    }else{ $honoraire = 2 ;
                        $hono_valeur = $bien->taux_net + $bien->taux_prix;                     
                    }                                      
                    $this->add_element($xw,"agency_rates_type",$honoraire);                              
                    $this->add_element($xw,"agency_rates",$hono_valeur);                                          
                    $this->add_element($xw,"postal_code",$bien->code_postal);                                          
                    $this->add_element($xw,"city",$bien->ville);                                          
                    $this->add_element($xw,"summary_fr",$bien->titre_annonce);   
				    
				    $type_bien = array("maison" => "house", "appartement"=>"appartement", "terrain" => "land", "luxueux" => "castle", "commercial" => "business",
				    "parking" => "parking", "programme neuf"=> "new", "gite"=>"gite" );
				  
		                                  
                    $this->add_element($xw,"country_code","fr");                                          
                    $this->add_element($xw,"property_type", $type_bien[$bien->type_bien]);                                          
                    // $this->add_element($xw,"h_surface",$bien->surface);                                          
                    // $this->add_element($xw,"l_surface",$bien->surface_terrain);                                          
                    $this->add_element($xw,"dpe_type",$biendetail->diagnostic_dpe_consommation);                                          
                    $this->add_element($xw,"dpe_value","");                                          
                    $this->add_element($xw,"ges_type",$biendetail->diagnostic_dpe_ges );                                          
                    $this->add_element($xw,"ges_value","");                                          
                    xmlwriter_start_element($xw,"pics");
                        foreach ($bien->photosbiens as $photo) {
                            xmlwriter_start_element($xw,"pic");
                                xmlwriter_start_attribute($xw,"order");                        
                                    xmlwriter_text($xw, $photo->image_position);
                                xmlwriter_end_attribute($xw);  
                                xmlwriter_text($xw, $this->passerelles_path.'/'.$photo->filename);
                            xmlwriter_end_element($xw);
                        }
                        
                    xmlwriter_end_element($xw);	

                    xmlwriter_end_element($xw);	// Fin element advert
                    }

                    //### Diffusion planifiée
                    foreach ($diffs_plans as $diff_plan) {
    
                        $bien = $diff_plan->bien;
                        
                        
                        $biendetail = $bien->biendetail;
                        $annonce = $diff_plan->annonce;

                    //Biens à la vente
                    xmlwriter_start_element($xw,"advert");
                    
               
                    $this->add_element($xw,"account_id","xxxxxxxx");                                          
                    $this->add_element($xw,"reference","xxxxxxxx");                                          
                    $this->add_element($xw,"price",$annonce != null ? $annonce->prix : $bien->prix_public);                                          
                    $this->add_element($xw,"currency","EUR");                                          
                    $this->add_element($xw,"has_included_fees",1);    
                    $this->add_element($xw,"fees",$bien->frais_agence);    
                    $this->add_element($xw,"agency_rate_scale_url","https://www.stylimmo.com/bareme.php");    
                    
                    if($bien->honoraire_vendeur == "Oui" && $bien->honoraire_acquereur == "Non"){
                        $honoraire = 0;
                        $hono_valeur = $bien->taux_prix; 
                    }elseif($bien->honoraire_vendeur == "Non" && $bien->honoraire_acquereur == "Oui"){
                        $honoraire = 1;
                        $hono_valeur = $bien->taux_net; 
                    }else{ $honoraire = 2 ;
                        $hono_valeur = $bien->taux_net + $bien->taux_prix;                     
                    }                                      
                    $this->add_element($xw,"agency_rates_type",$honoraire);                              
                    $this->add_element($xw,"agency_rates",$hono_valeur);                                          
                    $this->add_element($xw,"postal_code",$bien->code_postal);                                          
                    $this->add_element($xw,"city",$bien->ville);                                          
                    $this->add_element($xw,"type",$bien->type_offre == "vente" ? "properties" : "rentals");                                          
                    $this->add_element($xw,"summary_fr",$annonce != null ? $annonce->description:  $bien->description_annonce);   
                    $this->add_element($xw,"title_fr",$annonce != null ? $annonce->titre:  $bien->titre_annonce);   
				
		                                  
                    $this->add_element($xw,"country_code","fr");                                          
                    $this->add_element($xw,"property_type",$type_bien[$bien->type_bien]);                                          
                    // $this->add_element($xw,"h_surface",$bien->surface);                                          
                    // $this->add_element($xw,"l_surface",$bien->surface_terrain);                                          
                    $this->add_element($xw,"dpe_type",$biendetail->diagnostic_dpe_consommation);                                          
                    $this->add_element($xw,"dpe_value","");                                          
                    $this->add_element($xw,"ges_type",$biendetail->diagnostic_dpe_ges );                                          
                    $this->add_element($xw,"ges_value","");                                          
                    xmlwriter_start_element($xw,"pics");
                        foreach ($bien->photosbiens as $photo) {
                            xmlwriter_start_element($xw,"pic");
                                xmlwriter_start_attribute($xw,"order");                        
                                    xmlwriter_text($xw, $photo->image_position);
                                xmlwriter_end_attribute($xw);  
                                xmlwriter_text($xw, $this->passerelles_path.'/'.$photo->filename);
                            xmlwriter_end_element($xw);
                        }
                        
                    xmlwriter_end_element($xw);	

                    xmlwriter_end_element($xw);	// Fin element advert
                   
                    }

                }
                    
                    

							
                xmlwriter_end_element($xw); // Fin element add_adverts

              
        xmlwriter_end_element($xw); //Fin element Body
        xmlwriter_end_element($xw); //Fin element Envelope
    
        //Fin  du document
    xmlwriter_end_document($xw);
    	file_put_contents ($this->passerelles_path.'/greenacres.xml',xmlwriter_output_memory($xw));
       dd( xmlwriter_output_memory($xw) );
	}
	
	
	
	 /** Fonction d'export de seLoger
    * @author jean-philippe
    * @param  App\Models\PhotosBien
    * @return \Illuminate\Http\Response
    **/	
    public function exportSeLoger(){
         
        $fp = fopen($this->passerelles_path.'/Annonces.csv','w');
        $list = array();
        $exports = $this->datas("logicimmo");

                        
                        
                        
        foreach($exports as $export){
        
            $diffs_autos = $export['diffusion']['auto'];
            $diffs_plans = $export['diffusion']['plan'];
            $user = $export['user'];
            
           
            
            //### Diffusion automatique
            foreach($diffs_autos as $diff_auto){
            
                $bien = $diff_auto->bien; 
                $biendetail = $bien->biendetail;
               
               array_push($list, array(
                  "code_agence_01!#"    //#1 Identifiant agence
                  ."ref_".$bien->id."!#"    //#2 Référence agence du bien
                  .$bien->type_offre."!#"   //#3 Type d’annonce
                  .$bien->type_bien."!#"    //#4 Type de bien
                  .$bien->code_postal."!#"   //#5 CP
                  .$bien->ville."!#"   //#6 Ville
                  .$bien->pays."!#"   //#7 Pays
                  .$bien->adresse."!#"   //#8 Adresse
                  .$bien->proximite."!#"   //#9 Quartier / Proximité
                  ."!#"   //#10 Activités commerciales
                  .($bien->type_offre == "location" ?  $bien->loyer : $bien->prix_public)."!#"   //#11 Prix / Loyer / Prix de cession
                  ."!#"   //#12 Loyer / mois murs
                  ."!#"   //#13 Loyer CC
                  ."!#"   //#14 Loyer HT
                  .($bien->type_offre == "location" ?  $bien->honoraires_location : $bien->taux_prix+$bien->taux_net)."!#"   //#15 Honoraires  **********
                  .$bien->surface."!#"   //#16 Surface (m2)
                  .$bien->surface_terrain."!#"   //#17 Surface terrain (m2)
                  .$bien->nombre_piece."!#"   //#18 NB de pièces
                  .$bien->nombre_chambre."!#"   //#19 NB de chambres
                  .$bien->titre_annonce."!#"   //#20 Libellé
                  .$bien->description_annonce."!#"   //#21 Descriptif
                  .\Carbon\Carbon::parse($bien->disponible_le_dossier_dispo)->format('d/m/Y')."!#"   //#22 Date de disponibilité
                  .$bien->charge_mensuelle_total_info_fin."!#"   //#23 Charges
                  ."!#"   //#24 Etage
                  .$biendetail->agen_exter_etage."!#"   //#25 NB d’étages
                  .($biendetail->agen_inter_meuble == "Oui" ? "Oui": "Non")."!#"   //#26 Meublé
                  .$bien->diagnostic_annee_construction."!#"   //#27 Année de construction
                  ."!#"   //#28 Refait à neuf
                  .$biendetail->agen_inter_nb_salle_bain."!#"   //#29 NB de salles de bain
                  .$biendetail->agen_inter_nb_salle_eau."!#"   //#30 NB de salles d’eau
                  .$biendetail->agen_inter_nb_wc."!#"   //#31 NB de WC
                  ."!#"   //#32 WC séparés
                  ."!#"   //#33 Type de chauffage
                  ."!#"   //#34 Type de cuisine
                  ."!#"   //#35 Orientation sud
                  ."!#"   //#36 Orientation est
                  ."!#"   //#37 Orientation ouest
                  ."!#"   //#38 Orientation nord
                  .$biendetail->agen_exter_nb_balcon."!#"   //#39 NB balcons
                  .$biendetail->agen_exter_surface_balcon."!#"   //#40 SF Balcon
                  .($biendetail->equipement_ascenseur == "Oui" ? "Oui": "Non")."!#"   //#41 Ascenseur
                  ."!#"   //#42 Cave
                  .( $biendetail->agen_exter_parking_interieur + $biendetail->agen_exter_parking_exterieur)."!#"   //#43 NB de parkings
                  ."!#"   //#44 NB de boxes
                  ."!#"   //#45 Digicode
                  ."!#"   //#46 Interphone
                  ."!#"   //#47 Gardien
                  .($biendetail->agen_exter_terrasse == "Oui" ? "Oui": "Non")."!#"   //#48 Terrasse
                  ."!#"   //#49 Prix semaine Basse Saison
                  ."!#"   //#50 Prix quinzaine Basse Saison
                  ."!#"   //#51 Prix mois / Basse Saison
                  ."!#"   //#52 Prix semaine Haute Saison
                  ."!#"   //#53 Prix quinzaine Haute Saison
                  ."!#"   //#54 Prix mois Haute Saison
                  ."!#"   //#55 NB de personnes
                  ."!#"   //#56 Type de résidence
                  ."!#"   //#57 Situation
                  ."!#"   //#58 NB de couverts
                  ."!#"   //#59 NB de lits doubles
                  ."!#"   //#60 NB de lits simples
                  ."!#"   //#61 Alarme
                  ."!#"   //#62 Câble TV
                  ."!#"   //#63 Calme
                  ."!#"   //#64 Climatisation
                  .($bien->piscine == "Oui" ? "Oui": "Non")."!#"   //#65 Piscine
                  .($biendetail->equipement_acces_handicape == "Oui" ? "Oui": "Non")."!#"   //#66 Aménagement pour handicapés
                  ."!#"   //#67 Animaux acceptés
                  ."!#"   //#68 Cheminée
                  ."!#"   //#69 Congélateur
                  ."!#"   //#70 Four
                  ."!#"   //#71 Lave-vaisselle
                  ."!#"   //#72 Micro-ondes
                  ."!#"   //#73 Placards
                  ."!#"   //#74 Téléphone
                  ."!#"   //#75 Proche lac
                  ."!#"   //#76 Proche tennis
                  ."!#"   //#77 Proche pistes de ski
                  ."!#"   //#78 Vue dégagée
                  ."!#"   //#79 Chiffre d’affaire
                  ."!#"   //#80 Longueur façade (m)
                  ."!#"   //#81 Duplex
                  ."!#"   //#82 Publications
                  .( isset ($bien->mandat) ? ($bien->mandat->type =="Exclusif" ? "Oui" : "Non") : "" )."!#"   //#83 Mandat en exclusivité
                  ."!#"   //#84 Coup de coeur
                  .( isset($bien->photosbiens[0]) ? url('/')."/images/photos_bien/".$bien->photosbiens[0]->filename : "")."!#"   //#85 Photo 1
                  .( isset($bien->photosbiens[1]) ? url('/')."/images/photos_bien/".$bien->photosbiens[1]->filename : "")."!#"   //#86 Photo 2
                  .( isset($bien->photosbiens[2]) ? url('/')."/images/photos_bien/".$bien->photosbiens[2]->filename : "")."!#"   //#87 Photo 3
                  .( isset($bien->photosbiens[3]) ? url('/')."/images/photos_bien/".$bien->photosbiens[3]->filename : "")."!#"   //#88 Photo 4
                  .( isset($bien->photosbiens[4]) ? url('/')."/images/photos_bien/".$bien->photosbiens[4]->filename : "")."!#"   //#89 Photo 5
                  .( isset($bien->photosbiens[5]) ? url('/')."/images/photos_bien/".$bien->photosbiens[5]->filename : "")."!#"   //#90 Photo 6
                  .( isset($bien->photosbiens[6]) ? url('/')."/images/photos_bien/".$bien->photosbiens[6]->filename : "")."!#"   //#91 Photo 7
                  .( isset($bien->photosbiens[7]) ? url('/')."/images/photos_bien/".$bien->photosbiens[7]->filename : "")."!#"   //#92 Photo 8
                  .( isset($bien->photosbiens[8]) ? url('/')."/images/photos_bien/".$bien->photosbiens[8]->filename : "")."!#"   //#93 Photo 9
                  ."!#"   //#94 Titre photo 1
                  ."!#"   //#95 Titre photo 2
                  ."!#"   //#96 Titre photo 3
                  ."!#"   //#97 Titre photo 4
                  ."!#"   //#98 Titre photo 5
                  ."!#"   //#99 Titre photo 6
                  ."!#"   //#100 Titre photo 7
                  ."!#"   //#101 Titre photo 8
                  ."!#"   //#102 Titre photo 9
                  ."!#"   //#103 Photo panoramique
                  ."!#"   //#104 URL visite virtuelle
                  .$user->telephone."!#"   //#105 Téléphone à afficher
                  .$user->prenom.' '.$user->nom."!#"   //#106 Contact à afficher
                  .$user->email."!#"   //#107 Email de contact
                  .$bien->code_postal."!#"   //#108 CP Réel du bien
                  .$bien->ville."!#"   //#109 Ville réelle du bien
                  .$bien->xxxxxxxxxx."!#"   //#110 Inter-cabinet
                  .$bien->xxxxxxxxxx."!#"   //#111 Inter-cabinet prive
                  .$bien->mandat->numero."!#"   //#112 N° de mandat
                  .$bien->mandat->date_debut."!#"   //#113 Date mandat
                  .$user->nom."!#"   //#114 Nom mandataire
                  .$user->prenom."!#"   //#115 Prénom mandataire
                  .$bien->xxxxxxxxxx."!#"   //#116 Raison sociale mandataire
                  .$user->adresse."!#"   //#117 Adresse mandataire
                  .$user->code_postal."!#"   //#118 CP mandataire
                  .$user->ville."!#"   //#119 Ville mandataire
                  .$user->telephone1."!#"   //#120 Téléphone mandataire
                  .$bien->xxxxxxxxxx."!#"   //#121 Commentaires mandataire
                  .$bien->xxxxxxxxxx."!#"   //#122 Commentaires privés
                  .$bien->xxxxxxxxxx."!#"   //#123 Code négociateur
                  .$bien->xxxxxxxxxx."!#"   //#124 Code Langue 1
                  .$bien->xxxxxxxxxx."!#"   //#125 Proximité Langue 1
                  .$bien->xxxxxxxxxx."!#"   //#126 Libellé Langue 1
                  .$bien->xxxxxxxxxx."!#"   //#127 Descriptif Langue 1
                  .$bien->xxxxxxxxxx."!#"   //#128 Code Langue 2
                  .$bien->xxxxxxxxxx."!#"   //#129 Proximité Langue 2
                  .$bien->xxxxxxxxxx."!#"   //#130 Libellé Langue 2
                  .$bien->xxxxxxxxxx."!#"   //#131 Descriptif Langue 2
                  .$bien->xxxxxxxxxx."!#"   //#132 Code Langue 3
                  .$bien->xxxxxxxxxx."!#"   //#133 Proximité Langue 3
                  .$bien->xxxxxxxxxx."!#"   //#134 Libellé Langue 3
                  .$bien->xxxxxxxxxx."!#"   //#135 Descriptif Langue 3
                  .$bien->xxxxxxxxxx."!#"   //#136 Champ personnalisé 1
                  .$bien->xxxxxxxxxx."!#"   //#137 Champ personnalisé 2
                  .$bien->xxxxxxxxxx."!#"   //#138 Champ personnalisé 3
                  .$bien->xxxxxxxxxx."!#"   //#139 Champ personnalisé 4
                  .$bien->xxxxxxxxxx."!#"   //#140 Champ personnalisé 5
                  .$bien->xxxxxxxxxx."!#"   //#141 Champ personnalisé 6
                  .$bien->xxxxxxxxxx."!#"   //#142 Champ personnalisé 7
                  .$bien->xxxxxxxxxx."!#"   //#143 Champ personnalisé 8
                  .$bien->xxxxxxxxxx."!#"   //#144 Champ personnalisé 9
                  .$bien->xxxxxxxxxx."!#"   //#145 Champ personnalisé 10
                  .$bien->xxxxxxxxxx."!#"   //#146 Champ personnalisé 11
                  .$bien->xxxxxxxxxx."!#"   //#147 Champ personnalisé 12
                  .$bien->xxxxxxxxxx."!#"   //#148 Champ personnalisé 13
                  .$bien->xxxxxxxxxx."!#"   //#149 Champ personnalisé 14
                  .$bien->xxxxxxxxxx."!#"   //#150 Champ personnalisé 15
                  .$bien->xxxxxxxxxx."!#"   //#151 Champ personnalisé 16
                  .$bien->xxxxxxxxxx."!#"   //#152 Champ personnalisé 17
                  .$bien->xxxxxxxxxx."!#"   //#153 Champ personnalisé 18
                  .$bien->xxxxxxxxxx."!#"   //#154 Champ personnalisé 19
                  .$bien->xxxxxxxxxx."!#"   //#155 Champ personnalisé 20
                  .$bien->xxxxxxxxxx."!#"   //#156 Champ personnalisé 21
                  .$bien->xxxxxxxxxx."!#"   //#157 Champ personnalisé 22
                  .$bien->xxxxxxxxxx."!#"   //#158 Champ personnalisé 23
                  .$bien->xxxxxxxxxx."!#"   //#159 Champ personnalisé 24
                  .$bien->xxxxxxxxxx."!#"   //#160 Champ personnalisé 25
                  .$bien->xxxxxxxxxx."!#"   //#161 Dépôt de garantie
                  .$bien->xxxxxxxxxx."!#"   //#162 Récent
                  .$bien->travaux_a_prevoir."!#"   //#163 Travaux à prévoir
                  .( isset($bien->photosbiens[0]) ? url('/')."/images/photos_bien/".$bien->photosbiens[0]->filename : "")."!#"   //#164 Photo 10
                  .( isset($bien->photosbiens[1]) ? url('/')."/images/photos_bien/".$bien->photosbiens[1]->filename : "")."!#"   //#165 Photo 11
                  .( isset($bien->photosbiens[2]) ? url('/')."/images/photos_bien/".$bien->photosbiens[2]->filename : "")."!#"   //#166 Photo 12
                  .( isset($bien->photosbiens[3]) ? url('/')."/images/photos_bien/".$bien->photosbiens[3]->filename : "")."!#"   //#167 Photo 13
                  .( isset($bien->photosbiens[4]) ? url('/')."/images/photos_bien/".$bien->photosbiens[4]->filename : "")."!#"   //#168 Photo 14
                  .( isset($bien->photosbiens[5]) ? url('/')."/images/photos_bien/".$bien->photosbiens[5]->filename : "")."!#"   //#169 Photo 15
                  .( isset($bien->photosbiens[6]) ? url('/')."/images/photos_bien/".$bien->photosbiens[6]->filename : "")."!#"   //#170 Photo 16
                  .( isset($bien->photosbiens[7]) ? url('/')."/images/photos_bien/".$bien->photosbiens[7]->filename : "")."!#"   //#171 Photo 17
                  .( isset($bien->photosbiens[8]) ? url('/')."/images/photos_bien/".$bien->photosbiens[8]->filename : "")."!#"   //#172 Photo 18
                  .( isset($bien->photosbiens[8]) ? url('/')."/images/photos_bien/".$bien->photosbiens[8]->filename : "")."!#"   //#173 Photo 19
                  .( isset($bien->photosbiens[8]) ? url('/')."/images/photos_bien/".$bien->photosbiens[8]->filename : "")."!#"   //#174 Photo 20
                  ."id_tech".$bien->id."!#"   //#175 Identifiant technique  *************
                  .$bien->diagnostic_dpe_consommation."!#"   //#176 Consommation énergie
                  .$bien->xxxxxxxxxx."!#"   //#177 Bilan consommation énergie
                  .$bien->diagnostic_dpe_ges."!#"   //#178 Emissions GES
                  .$bien->xxxxxxxxxx."!#"   //#179 Bilan émission GES
                  .$bien->xxxxxxxxxx."!#"   //#180 Identifiant quartier (obsolète)
                  .$bien->type_type_bien."!#"   //#181 Sous type de bien
                  .$bien->xxxxxxxxxx."!#"   //#182 Périodes de disponibilité
                  .$bien->xxxxxxxxxx."!#"   //#183 Périodes basse saison
                  .$bien->xxxxxxxxxx."!#"   //#184 Périodes haute saison
                  .$bien->xxxxxxxxxx."!#"   //#185 Prix du bouquet
                  .$bien->xxxxxxxxxx."!#"   //#186 Rente mensuelle
                  .$bien->xxxxxxxxxx."!#"   //#187 Age de l’homme
                  .$bien->xxxxxxxxxx."!#"   //#188 Age de la femme
                  .$bien->xxxxxxxxxx."!#"   //#189 Entrée
                  .$bien->xxxxxxxxxx."!#"   //#190 Résidence
                  .$bien->xxxxxxxxxx."!#"   //#191 Parquet
                  .$bien->xxxxxxxxxx."!#"   //#192 Vis-à-vis
                  .$bien->xxxxxxxxxx."!#"   //#193 Transport : Ligne
                  .$bien->xxxxxxxxxx."!#"   //#194 Transport : Station
                  .$bien->xxxxxxxxxx."!#"   //#195 Durée bail
                  .$bien->xxxxxxxxxx."!#"   //#196 Places en salle
                  .$bien->xxxxxxxxxx."!#"   //#197 Monte-charge
                  .$bien->xxxxxxxxxx."!#"   //#198 Quai
                  .$bien->xxxxxxxxxx."!#"   //#199 Nombre de bureaux
                  .$bien->xxxxxxxxxx."!#"   //#200 Prix du droit d’entrée
                  .$bien->xxxxxxxxxx."!#"   //#201 Prix masqué
                  .$bien->xxxxxxxxxx."!#"   //#202 Loyer annuel global
                  .$bien->xxxxxxxxxx."!#"   //#203 Charges annuelles globales
                  .$bien->xxxxxxxxxx."!#"   //#204 Loyer annuel au m2
                  .$bien->xxxxxxxxxx."!#"   //#205 Charges annuelles au m2
                  .$bien->xxxxxxxxxx."!#"   //#206 Charges mensuelles HT
                  .$bien->xxxxxxxxxx."!#"   //#207 Loyer annuel CC
                  .$bien->xxxxxxxxxx."!#"   //#208 Loyer annuel HT
                  .$bien->xxxxxxxxxx."!#"   //#209 Charges annuelles HT
                  .$bien->xxxxxxxxxx."!#"   //#210 Loyer annuel au m2 CC
                  .$bien->xxxxxxxxxx."!#"   //#211 Loyer annuel au m2 HT
                  .$bien->xxxxxxxxxx."!#"   //#212 Charges annuelles au m2 HT
                  .$bien->xxxxxxxxxx."!#"   //#213 Divisible
                  .$bien->xxxxxxxxxx."!#"   //#214 Surface divisible minimale
                  .$bien->xxxxxxxxxx."!#"   //#215 Surface divisible maximale
                  .$biendetail->agen_inter_surface_sejour."!#"   //#216 Surface séjour
                  .$bien->xxxxxxxxxx."!#"   //#217 Nombre de véhicules
                  .$bien->xxxxxxxxxx."!#"   //#218 Prix du droit au bail
                  .$bien->xxxxxxxxxx."!#"   //#219 Valeur à l’achat
                  .$bien->xxxxxxxxxx."!#"   //#220 Répartition du chiffre d’affaire
                  .$bien->xxxxxxxxxx."!#"   //#221 Terrain agricole
                  .$bien->xxxxxxxxxx."!#"   //#222 Equipement bébé
                  .strtoupper($biendetail->terrain_constructible)."!#"   //#223 Terrain constructible
                  .$bien->xxxxxxxxxx."!#"   //#224 Résultat Année N-2
                  .$bien->xxxxxxxxxx."!#"   //#225 Résultat Année N-1
                  .$bien->xxxxxxxxxx."!#"   //#226 Résultat Actuel
                  .$bien->xxxxxxxxxx."!#"   //#227 Immeuble de parkings
                  .$bien->xxxxxxxxxx."!#"   //#228 Parking isolé
                  .$bien->xxxxxxxxxx."!#"   //#229 Si Viager Vendu Libre
                  .$bien->xxxxxxxxxx."!#"   //#230 Logement à disposition
                  .$bien->xxxxxxxxxx."!#"   //#231 Terrain en pente
                  .$bien->xxxxxxxxxx."!#"   //#232 Plan d’eau
                  .$bien->xxxxxxxxxx."!#"   //#233 Lave-linge
                  .$bien->xxxxxxxxxx."!#"   //#234 Sèche-linge
                  .$bien->xxxxxxxxxx."!#"   //#235 Connexion internet
                  .$bien->xxxxxxxxxx."!#"   //#236 Chiffre affaire Année N-2
                  .$bien->xxxxxxxxxx."!#"   //#237 Chiffre affaire Année N-1
                  .$bien->xxxxxxxxxx."!#"   //#238 Conditions financières
                  .$bien->xxxxxxxxxx."!#"   //#239 Prestations diverses
                  .$bien->xxxxxxxxxx."!#"   //#240 Longueur façade
                  .$bien->xxxxxxxxxx."!#"   //#241 Montant du rapport
                  .$bien->xxxxxxxxxx."!#"   //#242 Nature du bail
                  .$bien->xxxxxxxxxx."!#"   //#243 Nature bail commercial
                  .$biendetail->agen_exter_nb_terrasse."!#"   //#244 Nombre terrasses
                  .$bien->xxxxxxxxxx."!#"   //#245 Prix hors taxes
                  .$bien->xxxxxxxxxx."!#"   //#246 Si Salle à manger
                  .$bien->xxxxxxxxxx."!#"   //#247 Si Séjour
                  .$bien->xxxxxxxxxx."!#"   //#248 Terrain donne sur la rue
                  .$bien->xxxxxxxxxx."!#"   //#249 Immeuble de type bureaux
                  .$bien->xxxxxxxxxx."!#"   //#250 Terrain viabilisé
                  .$bien->xxxxxxxxxx."!#"   //#251 Equipement Vidéo
                  .$bien->xxxxxxxxxx."!#"   //#252 Surface de la cave
                  .$bien->xxxxxxxxxx."!#"   //#253 Surface de la salle à manger
                  .$bien->xxxxxxxxxx."!#"   //#254 Situation commerciale
                  .$bien->xxxxxxxxxx."!#"   //#255 Surface maximale d’un bureau
                  .$bien->xxxxxxxxxx."!#"   //#256 Honoraires charge acquéreur (obsolète)
                  .$bien->xxxxxxxxxx."!#"   //#257 Pourcentage honoraires TTC (obsolète)
                  .$bien->xxxxxxxxxx."!#"   //#258 En copropriété
                  .$biendetail->copropriete_nombre_lot."!#"   //#259 Nombre de lots
                  .$bien->xxxxxxxxxx."!#"   //#260 Charges annuelles
                  .$bien->xxxxxxxxxx."!#"   //#261 Syndicat des copropriétaires en procédure
                  .$bien->xxxxxxxxxx."!#"   //#262 Détail procédure du syndicat des copropriétaires
                  .$bien->xxxxxxxxxx."!#"   //#263 Champ personnalisé 26
                  .( isset($bien->photosbiens[21]) ? url('/')."/images/photos_bien/".$bien->photosbiens[21]->filename : "")."!#"   //#264 Photo 21
                  .( isset($bien->photosbiens[22]) ? url('/')."/images/photos_bien/".$bien->photosbiens[22]->filename : "")."!#"   //#265 Photo 22
                  .( isset($bien->photosbiens[23]) ? url('/')."/images/photos_bien/".$bien->photosbiens[23]->filename : "")."!#"   //#266 Photo 23
                  .( isset($bien->photosbiens[24]) ? url('/')."/images/photos_bien/".$bien->photosbiens[24]->filename : "")."!#"   //#267 Photo 24
                  .( isset($bien->photosbiens[25]) ? url('/')."/images/photos_bien/".$bien->photosbiens[25]->filename : "")."!#"   //#268 Photo 25
                  .( isset($bien->photosbiens[26]) ? url('/')."/images/photos_bien/".$bien->photosbiens[26]->filename : "")."!#"   //#269 Photo 26
                  .( isset($bien->photosbiens[27]) ? url('/')."/images/photos_bien/".$bien->photosbiens[27]->filename : "")."!#"   //#270 Photo 27
                  .( isset($bien->photosbiens[28]) ? url('/')."/images/photos_bien/".$bien->photosbiens[28]->filename : "")."!#"   //#271 Photo 28
                  .( isset($bien->photosbiens[29]) ? url('/')."/images/photos_bien/".$bien->photosbiens[29]->filename : "")."!#"   //#272 Photo 29
                  .( isset($bien->photosbiens[30]) ? url('/')."/images/photos_bien/".$bien->photosbiens[30]->filename : "")."!#"   //#273 Photo 30
                  ."!#"   //#274 Titre photo 10
                  ."!#"   //#275 Titre photo 11
                  ."!#"   //#276 Titre photo 12
                  ."!#"   //#277 Titre photo 13
                  ."!#"   //#278 Titre photo 14
                  ."!#"   //#279 Titre photo 15
                  ."!#"   //#280 Titre photo 16
                  ."!#"   //#281 Titre photo 17
                  ."!#"   //#282 Titre photo 18
                  ."!#"   //#283 Titre photo 19
                  ."!#"   //#284 Titre photo 20
                  ."!#"   //#285 Titre photo 21
                  ."!#"   //#286 Titre photo 22
                  ."!#"   //#287 Titre photo 23
                  ."!#"   //#288 Titre photo 24
                  ."!#"   //#289 Titre photo 25
                  ."!#"   //#290 Titre photo 26
                  ."!#"   //#291 Titre photo 27
                  ."!#"   //#292 Titre photo 28
                  ."!#"   //#293 Titre photo 29
                  ."!#"   //#294 Titre photo 30
                  ."!#"   //#295 Prix du terrain
                  ."!#"   //#296 Prix du modèle de maison
                  ."!#"   //#297 Nom de l'agence gérant le terrain
                  ."!#"   //#298 Latitude
                  ."!#"   //#299 Longitude
                  ."!#"   //#300 Précision GPS
                  ."4.11!#"   //#301 Version Format
                  .(($bien->honoraire_acquereur == "Oui" ) ? 1:2 )."!#"   //#302 Honoraires à la charge de
                  .$bien->prix_prive."!#"   //#303 Prix hors honoraires acquéreur
                  ."1!#"   //#304 Modalités charges locataire   ***********
                  .$bien->complement_loyer."!#"   //#305 Complément loyer
                  ."0!#"   //#306 Part honoraires état des lieux
                  ."!#"   //#307 URL du Barème des honoraires de l’Agence                  
                  ."1!#"   //#308 Prix minimum 
                  ."10000000000!#"   //#309 Prix maximum
                  ."1!#"   //#310 Surface minimale
                  ."10000!#"   //#311 Surface maximale
                  ."1!#"   //#312 Nombre de pièces minimum                  
                  ."20!#"   //#313 Nombre de pièces maximum
                  ."1!#"   //#314 Nombre de chambres minimum
                  ."20!#"   //#315 Nombre de chambres maximum
                  ."!#"   //#316 ID type étage
                  ."!#"   //#317 Si combles aménageables
                  ."!#"   //#318 Si garage
                  ."!#"   //#319 ID type garage 
                  ."!#"   //#320 Si possibilité mitoyenneté
                  ."!#"   //#321 Surface terrain nécessaire
                  ."!#"   //#322 Localisation
                  ."!#"   //#323 Nom du modèle 
                  ."!#"   //#324 Date réalisation DPE
                  ."!#"   //#325 Version DPE
                  ."!#"   //#326 DPE coût min conso
                  ."!#"   //#327 DPE coût max conso D
                  ."!#"   //#328 DPE date référence conso                  
                  ."!#"   //#329 Surface terrasse
                  ."!#"   //#330 DPE coût conso annuelle
                  ."!#"   //#331 Loyer de base
                  ."!#"   //#332 Loyer de référence majoré
                  ."!#"   //#333 Encadrement des loyers
                  ."!#"   //#334 Risque Pollution
                  ."!#"   //#335 Date ERP
                  
               )
               );
               
            }
        }
        
       //  dd($list);
        $separator = "*";
        $enclosure = "*";
        $escape = "\\";
        $eol = "\n";
        
        foreach ($list as $fields) {
            fputcsv($fp, $fields, $separator, $enclosure, $escape);
        }
      
        fclose($fp);
       // dd($users_biens);

   }
   
   
   
    /** Fonction d'export de Paruvendu
    * @author jean-philippe
    * @param  App\Models\PhotosBien
    * @return \Illuminate\Http\Response
    **/	
    public function exportParuvendu($users_biens){
         
         
         
        
        $fp = fopen($this->passerelles_path.'/annonces2.csv','w');
        $list = array();
       //  dd($users_biens);

        foreach($users_biens as $user_biens){
            foreach($user_biens[1] as $bien){
               
               array_push($list, array(
                  "code_agence_01!#"    //#1 Identifiant agence
                  ."ref_".$bien->id."!#"    //#2 Référence agence du bien
                  .$bien->type_offre."!#"   //#3 Type d’annonce
                  .$bien->type_bien."!#"    //#4 Type de bien
                  .$bien->code_postal."!#"   //#5 CP
                  .$bien->ville."!#"   //#6 Ville
                  .$bien->pays."!#"   //#7 Pays
                  .$bien->adresse."!#"   //#8 Adresse
                  .$bien->proximite_secteur."!#"   //#9 Quartier / Proximité
                  ."!#"   //#10 Activités commerciales
                  .($bien->type_offre == "location" ?  $bien->loyer : $bien->prix_public)."!#"   //#11 Prix / Loyer / Prix de cession
                  ."!#"   //#12 Loyer / mois murs
                  .$bien->loyer."!#"   //#13 Loyer CC
                  ."!#"   //#14 Loyer HT
                  .($bien->type_offre == "location" ?  750 : 5.5)."!#"   //#15 Honoraires  **********
                  .$bien->surface."!#"   //#16 Surface (m2)
                  .$bien->surface_terrain."!#"   //#17 Surface terrain (m2)
                  .$bien->nombre_piece."!#"   //#18 NB de pièces
                  .$bien->nombre_chambre."!#"   //#19 NB de chambres
                  .$bien->titre_annonce."!#"   //#20 Libellé
                  .$bien->description_annonce."!#"   //#21 Descriptif
                  .\Carbon\Carbon::parse($bien->disponible_le_dossier_dispo)->format('d/m/Y')."!#"   //#22 Date de disponibilité
                  .$bien->charge_mensuelle_total_info_fin."!#"   //#23 Charges
                  ."!#"   //#24 Etage
                  .$bien->etages_agencement_exterieur."!#"   //#25 NB d’étages
                  .($bien->meuble_agencement_interieur == "Oui" ? "Oui": "Non")."!#"   //#26 Meublé
                  .$bien->annee_construction_diagnostic."!#"   //#27 Année de construction
                  ."!#"   //#28 Refait à neuf
                  .$bien->nb_salle_bain_agencement_interieur."!#"   //#29 NB de salles de bain
                  .$bien->nb_salle_eau_agencement_interieur."!#"   //#30 NB de salles d’eau
                  .$bien->nb_wc_agencement_interieur."!#"   //#31 NB de WC
                  ."!#"   //#32 WC séparés
                  ."!#"   //#33 Type de chauffage
                  ."!#"   //#34 Type de cuisine
                  ."!#"   //#35 Orientation sud
                  ."!#"   //#36 Orientation est
                  ."!#"   //#37 Orientation ouest
                  ."!#"   //#38 Orientation nord
                  .$bien->nb_balcon_agencement_exterieur."!#"   //#39 NB balcons
                  .$bien->surface_balcon_agencement_exterieur."!#"   //#40 SF Balcon
                  .($bien->ascenseur_equipement == "Oui" ? "Oui": "Non")."!#"   //#41 Ascenseur
                  ."!#"   //#42 Cave
                  .( $bien->parking_interieur_agencement_exterieur + $bien->parking_exterieur_agencement_exterieur)."!#"   //#43 NB de parkings
                  ."!#"   //#44 NB de boxes
                  ."!#"   //#45 Digicode
                  ."!#"   //#46 Interphone
                  ."!#"   //#47 Gardien
                  .($bien->terrasse_agencement_exterieur == "Oui" ? "Oui": "Non")."!#"   //#48 Terrasse
                  ."!#"   //#49 Prix semaine Basse Saison
                  ."!#"   //#50 Prix quinzaine Basse Saison
                  ."!#"   //#51 Prix mois / Basse Saison
                  ."!#"   //#52 Prix semaine Haute Saison
                  ."!#"   //#53 Prix quinzaine Haute Saison
                  ."!#"   //#54 Prix mois Haute Saison
                  ."!#"   //#55 NB de personnes
                  ."!#"   //#56 Type de résidence
                  ."!#"   //#57 Situation
                  ."!#"   //#58 NB de couverts
                  ."!#"   //#59 NB de lits doubles
                  ."!#"   //#60 NB de lits simples
                  ."!#"   //#61 Alarme
                  ."!#"   //#62 Câble TV
                  ."!#"   //#63 Calme
                  ."!#"   //#64 Climatisation
                  .($bien->piscine == "Oui" ? "Oui": "Non")."!#"   //#65 Piscine
                  .($bien->acces_handicape_equipement == "Oui" ? "Oui": "Non")."!#"   //#66 Aménagement pour handicapés
                  ."!#"   //#67 Animaux acceptés
                  ."!#"   //#68 Cheminée
                  ."!#"   //#69 Congélateur
                  ."!#"   //#70 Four
                  ."!#"   //#71 Lave-vaisselle
                  ."!#"   //#72 Micro-ondes
                  ."!#"   //#73 Placards
                  ."!#"   //#74 Téléphone
                  ."!#"   //#75 Proche lac
                  ."!#"   //#76 Proche tennis
                  ."!#"   //#77 Proche pistes de ski
                  ."!#"   //#78 Vue dégagée
                  ."!#"   //#79 Chiffre d’affaire
                  ."!#"   //#80 Longueur façade (m)
                  ."!#"   //#81 Duplex
                  ."!#"   //#82 Publications
                  .( isset ($bien->mandat_ok) ? ($bien->mandat_ok->type =="exclusif" ? "Oui" : "Non") : "" )."!#"   //#83 Mandat en exclusivité
                  ."!#"   //#84 Coup de coeur
                  .( isset($bien->photosbiens[0]) ? url('/')."/images/photos_bien/".$bien->photosbiens[0]->filename : "")."!#"   //#85 Photo 1
                  .( isset($bien->photosbiens[1]) ? url('/')."/images/photos_bien/".$bien->photosbiens[1]->filename : "")."!#"   //#86 Photo 2
                  .( isset($bien->photosbiens[2]) ? url('/')."/images/photos_bien/".$bien->photosbiens[2]->filename : "")."!#"   //#87 Photo 3
                  .( isset($bien->photosbiens[3]) ? url('/')."/images/photos_bien/".$bien->photosbiens[3]->filename : "")."!#"   //#88 Photo 4
                  .( isset($bien->photosbiens[4]) ? url('/')."/images/photos_bien/".$bien->photosbiens[4]->filename : "")."!#"   //#89 Photo 5
                  .( isset($bien->photosbiens[5]) ? url('/')."/images/photos_bien/".$bien->photosbiens[5]->filename : "")."!#"   //#90 Photo 6
                  .( isset($bien->photosbiens[6]) ? url('/')."/images/photos_bien/".$bien->photosbiens[6]->filename : "")."!#"   //#91 Photo 7
                  .( isset($bien->photosbiens[7]) ? url('/')."/images/photos_bien/".$bien->photosbiens[7]->filename : "")."!#"   //#92 Photo 8
                  .( isset($bien->photosbiens[8]) ? url('/')."/images/photos_bien/".$bien->photosbiens[8]->filename : "")."!#"   //#93 Photo 9
                  ."!#"   //#94 Titre photo 1
                  ."!#"   //#95 Titre photo 2
                  ."!#"   //#96 Titre photo 3
                  ."!#"   //#97 Titre photo 4
                  ."!#"   //#98 Titre photo 5
                  ."!#"   //#99 Titre photo 6
                  ."!#"   //#100 Titre photo 7
                  ."!#"   //#101 Titre photo 8
                  ."!#"   //#102 Titre photo 9
                  ."!#"   //#103 Photo panoramique
                  ."!#"   //#104 URL visite virtuelle
                  .$user_biens[0]->telephone."!#"   //#105 Téléphone à afficher
                  ."!#"   //#106 Contact à afficher
                  .$user_biens[0]->email."!#"   //#107 Email de contact
                  .$bien->xxxxxxxxxx."!#"   //#108 CP Réel du bien
                  .$bien->xxxxxxxxxx."!#"   //#109 Ville réelle du bien
                  .$bien->xxxxxxxxxx."!#"   //#110 Inter-cabinet
                  .$bien->xxxxxxxxxx."!#"   //#111 Inter-cabinet prive
                  .$bien->xxxxxxxxxx."!#"   //#112 N° de mandat
                  .$bien->xxxxxxxxxx."!#"   //#113 Date mandat
                  .$bien->xxxxxxxxxx."!#"   //#114 Nom mandataire
                  .$bien->xxxxxxxxxx."!#"   //#115 Prénom mandataire
                  .$bien->xxxxxxxxxx."!#"   //#116 Raison sociale mandataire
                  .$bien->xxxxxxxxxx."!#"   //#117 Adresse mandataire
                  .$bien->xxxxxxxxxx."!#"   //#118 CP mandataire
                  .$bien->xxxxxxxxxx."!#"   //#119 Ville mandataire
                  .$bien->xxxxxxxxxx."!#"   //#120 Téléphone mandataire
                  .$bien->xxxxxxxxxx."!#"   //#121 Commentaires mandataire
                  .$bien->xxxxxxxxxx."!#"   //#122 Commentaires privés
                  .$bien->xxxxxxxxxx."!#"   //#123 Code négociateur
                  .$bien->xxxxxxxxxx."!#"   //#124 Code Langue 1
                  .$bien->xxxxxxxxxx."!#"   //#125 Proximité Langue 1
                  .$bien->xxxxxxxxxx."!#"   //#126 Libellé Langue 1
                  .$bien->xxxxxxxxxx."!#"   //#127 Descriptif Langue 1
                  .$bien->xxxxxxxxxx."!#"   //#128 Code Langue 2
                  .$bien->xxxxxxxxxx."!#"   //#129 Proximité Langue 2
                  .$bien->xxxxxxxxxx."!#"   //#130 Libellé Langue 2
                  .$bien->xxxxxxxxxx."!#"   //#131 Descriptif Langue 2
                  .$bien->xxxxxxxxxx."!#"   //#132 Code Langue 3
                  .$bien->xxxxxxxxxx."!#"   //#133 Proximité Langue 3
                  .$bien->xxxxxxxxxx."!#"   //#134 Libellé Langue 3
                  .$bien->xxxxxxxxxx."!#"   //#135 Descriptif Langue 3
                  .$bien->xxxxxxxxxx."!#"   //#136 Champ personnalisé 1
                  .$bien->xxxxxxxxxx."!#"   //#137 Champ personnalisé 2
                  .$bien->xxxxxxxxxx."!#"   //#138 Champ personnalisé 3
                  .$bien->xxxxxxxxxx."!#"   //#139 Champ personnalisé 4
                  .$bien->xxxxxxxxxx."!#"   //#140 Champ personnalisé 5
                  .$bien->xxxxxxxxxx."!#"   //#141 Champ personnalisé 6
                  .$bien->xxxxxxxxxx."!#"   //#142 Champ personnalisé 7
                  .$bien->xxxxxxxxxx."!#"   //#143 Champ personnalisé 8
                  .$bien->xxxxxxxxxx."!#"   //#144 Champ personnalisé 9
                  .$bien->xxxxxxxxxx."!#"   //#145 Champ personnalisé 10
                  .$bien->xxxxxxxxxx."!#"   //#146 Champ personnalisé 11
                  .$bien->xxxxxxxxxx."!#"   //#147 Champ personnalisé 12
                  .$bien->xxxxxxxxxx."!#"   //#148 Champ personnalisé 13
                  .$bien->xxxxxxxxxx."!#"   //#149 Champ personnalisé 14
                  .$bien->xxxxxxxxxx."!#"   //#150 Champ personnalisé 15
                  .$bien->xxxxxxxxxx."!#"   //#151 Champ personnalisé 16
                  .$bien->xxxxxxxxxx."!#"   //#152 Champ personnalisé 17
                  .$bien->xxxxxxxxxx."!#"   //#153 Champ personnalisé 18
                  .$bien->xxxxxxxxxx."!#"   //#154 Champ personnalisé 19
                  .$bien->xxxxxxxxxx."!#"   //#155 Champ personnalisé 20
                  .$bien->xxxxxxxxxx."!#"   //#156 Champ personnalisé 21
                  .$bien->xxxxxxxxxx."!#"   //#157 Champ personnalisé 22
                  .$bien->xxxxxxxxxx."!#"   //#158 Champ personnalisé 23
                  .$bien->xxxxxxxxxx."!#"   //#159 Champ personnalisé 24
                  .$bien->xxxxxxxxxx."!#"   //#160 Champ personnalisé 25
                  .$bien->xxxxxxxxxx."!#"   //#161 Dépôt de garantie
                  .$bien->xxxxxxxxxx."!#"   //#162 Récent
                  .$bien->xxxxxxxxxx."!#"   //#163 Travaux à prévoir
                  .( isset($bien->photosbiens[0]) ? url('/')."/images/photos_bien/".$bien->photosbiens[0]->filename : "")."!#"   //#164 Photo 10
                  .( isset($bien->photosbiens[1]) ? url('/')."/images/photos_bien/".$bien->photosbiens[1]->filename : "")."!#"   //#165 Photo 11
                  .( isset($bien->photosbiens[2]) ? url('/')."/images/photos_bien/".$bien->photosbiens[2]->filename : "")."!#"   //#166 Photo 12
                  .( isset($bien->photosbiens[3]) ? url('/')."/images/photos_bien/".$bien->photosbiens[3]->filename : "")."!#"   //#167 Photo 13
                  .( isset($bien->photosbiens[4]) ? url('/')."/images/photos_bien/".$bien->photosbiens[4]->filename : "")."!#"   //#168 Photo 14
                  .( isset($bien->photosbiens[5]) ? url('/')."/images/photos_bien/".$bien->photosbiens[5]->filename : "")."!#"   //#169 Photo 15
                  .( isset($bien->photosbiens[6]) ? url('/')."/images/photos_bien/".$bien->photosbiens[6]->filename : "")."!#"   //#170 Photo 16
                  .( isset($bien->photosbiens[7]) ? url('/')."/images/photos_bien/".$bien->photosbiens[7]->filename : "")."!#"   //#171 Photo 17
                  .( isset($bien->photosbiens[8]) ? url('/')."/images/photos_bien/".$bien->photosbiens[8]->filename : "")."!#"   //#172 Photo 18
                  .( isset($bien->photosbiens[8]) ? url('/')."/images/photos_bien/".$bien->photosbiens[8]->filename : "")."!#"   //#173 Photo 19
                  .( isset($bien->photosbiens[8]) ? url('/')."/images/photos_bien/".$bien->photosbiens[8]->filename : "")."!#"   //#174 Photo 20
                  ."id_tech".$bien->id."!#"   //#175 Identifiant technique  *************
                  .$bien->xxxxxxxxxx."!#"   //#176 Consommation énergie
                  .$bien->xxxxxxxxxx."!#"   //#177 Bilan consommation énergie
                  .$bien->xxxxxxxxxx."!#"   //#178 Emissions GES
                  .$bien->xxxxxxxxxx."!#"   //#179 Bilan émission GES
                  .$bien->xxxxxxxxxx."!#"   //#180 Identifiant quartier (obsolète)
                  .$bien->xxxxxxxxxx."!#"   //#181 Sous type de bien
                  .$bien->xxxxxxxxxx."!#"   //#182 Périodes de disponibilité
                  .$bien->xxxxxxxxxx."!#"   //#183 Périodes basse saison
                  .$bien->xxxxxxxxxx."!#"   //#184 Périodes haute saison
                  .$bien->xxxxxxxxxx."!#"   //#185 Prix du bouquet
                  .$bien->xxxxxxxxxx."!#"   //#186 Rente mensuelle
                  .$bien->xxxxxxxxxx."!#"   //#187 Age de l’homme
                  .$bien->xxxxxxxxxx."!#"   //#188 Age de la femme
                  .$bien->xxxxxxxxxx."!#"   //#189 Entrée
                  .$bien->xxxxxxxxxx."!#"   //#190 Résidence
                  .$bien->xxxxxxxxxx."!#"   //#191 Parquet
                  .$bien->xxxxxxxxxx."!#"   //#192 Vis-à-vis
                  .$bien->xxxxxxxxxx."!#"   //#193 Transport : Ligne
                  .$bien->xxxxxxxxxx."!#"   //#194 Transport : Station
                  .$bien->xxxxxxxxxx."!#"   //#195 Durée bail
                  .$bien->xxxxxxxxxx."!#"   //#196 Places en salle
                  .$bien->xxxxxxxxxx."!#"   //#197 Monte-charge
                  .$bien->xxxxxxxxxx."!#"   //#198 Quai
                  .$bien->xxxxxxxxxx."!#"   //#199 Nombre de bureaux
                  .$bien->xxxxxxxxxx."!#"   //#200 Prix du droit d’entrée
                  .$bien->xxxxxxxxxx."!#"   //#201 Prix masqué
                  .$bien->xxxxxxxxxx."!#"   //#202 Loyer annuel global
                  .$bien->xxxxxxxxxx."!#"   //#203 Charges annuelles globales
                  .$bien->xxxxxxxxxx."!#"   //#204 Loyer annuel au m2
                  .$bien->xxxxxxxxxx."!#"   //#205 Charges annuelles au m2
                  .$bien->xxxxxxxxxx."!#"   //#206 Charges mensuelles HT
                  .$bien->xxxxxxxxxx."!#"   //#207 Loyer annuel CC
                  .$bien->xxxxxxxxxx."!#"   //#208 Loyer annuel HT
                  .$bien->xxxxxxxxxx."!#"   //#209 Charges annuelles HT
                  .$bien->xxxxxxxxxx."!#"   //#210 Loyer annuel au m2 CC
                  .$bien->xxxxxxxxxx."!#"   //#211 Loyer annuel au m2 HT
                  .$bien->xxxxxxxxxx."!#"   //#212 Charges annuelles au m2 HT
                  .$bien->xxxxxxxxxx."!#"   //#213 Divisible
                  .$bien->xxxxxxxxxx."!#"   //#214 Surface divisible minimale
                  .$bien->xxxxxxxxxx."!#"   //#215 Surface divisible maximale
                  .$bien->xxxxxxxxxx."!#"   //#216 Surface séjour
                  .$bien->xxxxxxxxxx."!#"   //#217 Nombre de véhicules
                  .$bien->xxxxxxxxxx."!#"   //#218 Prix du droit au bail
                  .$bien->xxxxxxxxxx."!#"   //#219 Valeur à l’achat
                  .$bien->xxxxxxxxxx."!#"   //#220 Répartition du chiffre d’affaire
                  .$bien->xxxxxxxxxx."!#"   //#221 Terrain agricole
                  .$bien->xxxxxxxxxx."!#"   //#222 Equipement bébé
                  .$bien->xxxxxxxxxx."!#"   //#223 Terrain constructible
                  .$bien->xxxxxxxxxx."!#"   //#224 Résultat Année N-2
                  .$bien->xxxxxxxxxx."!#"   //#225 Résultat Année N-1
                  .$bien->xxxxxxxxxx."!#"   //#226 Résultat Actuel
                  .$bien->xxxxxxxxxx."!#"   //#227 Immeuble de parkings
                  .$bien->xxxxxxxxxx."!#"   //#228 Parking isolé
                  .$bien->xxxxxxxxxx."!#"   //#229 Si Viager Vendu Libre
                  .$bien->xxxxxxxxxx."!#"   //#230 Logement à disposition
                  .$bien->xxxxxxxxxx."!#"   //#231 Terrain en pente
                  .$bien->xxxxxxxxxx."!#"   //#232 Plan d’eau
                  .$bien->xxxxxxxxxx."!#"   //#233 Lave-linge
                  .$bien->xxxxxxxxxx."!#"   //#234 Sèche-linge
                  .$bien->xxxxxxxxxx."!#"   //#235 Connexion internet
                  .$bien->xxxxxxxxxx."!#"   //#236 Chiffre affaire Année N-2
                  .$bien->xxxxxxxxxx."!#"   //#237 Chiffre affaire Année N-1
                  .$bien->xxxxxxxxxx."!#"   //#238 Conditions financières
                  .$bien->xxxxxxxxxx."!#"   //#239 Prestations diverses
                  .$bien->xxxxxxxxxx."!#"   //#240 Longueur façade
                  .$bien->xxxxxxxxxx."!#"   //#241 Montant du rapport
                  .$bien->xxxxxxxxxx."!#"   //#242 Nature du bail
                  .$bien->xxxxxxxxxx."!#"   //#243 Nature bail commercial
                  .$bien->xxxxxxxxxx."!#"   //#244 Nombre terrasses
                  .$bien->xxxxxxxxxx."!#"   //#245 Prix hors taxes
                  .$bien->xxxxxxxxxx."!#"   //#246 Si Salle à manger
                  .$bien->xxxxxxxxxx."!#"   //#247 Si Séjour
                  .$bien->xxxxxxxxxx."!#"   //#248 Terrain donne sur la rue
                  .$bien->xxxxxxxxxx."!#"   //#249 Immeuble de type bureaux
                  .$bien->xxxxxxxxxx."!#"   //#250 Terrain viabilisé
                  .$bien->xxxxxxxxxx."!#"   //#251 Equipement Vidéo
                  .$bien->xxxxxxxxxx."!#"   //#252 Surface de la cave
                  .$bien->xxxxxxxxxx."!#"   //#253 Surface de la salle à manger
                  .$bien->xxxxxxxxxx."!#"   //#254 Situation commerciale
                  .$bien->xxxxxxxxxx."!#"   //#255 Surface maximale d’un bureau
                  .$bien->xxxxxxxxxx."!#"   //#256 Honoraires charge acquéreur (obsolète)
                  .$bien->xxxxxxxxxx."!#"   //#257 Pourcentage honoraires TTC (obsolète)
                  .$bien->xxxxxxxxxx."!#"   //#258 En copropriété
                  .$bien->xxxxxxxxxx."!#"   //#259 Nombre de lots
                  .$bien->xxxxxxxxxx."!#"   //#260 Charges annuelles
                  .$bien->xxxxxxxxxx."!#"   //#261 Syndicat des copropriétaires en procédure
                  .$bien->xxxxxxxxxx."!#"   //#262 Détail procédure du syndicat des copropriétaires
                  .$bien->xxxxxxxxxx."!#"   //#263 Champ personnalisé 26
                  .( isset($bien->photosbiens[21]) ? url('/')."/images/photos_bien/".$bien->photosbiens[21]->filename : "")."!#"   //#264 Photo 21
                  .( isset($bien->photosbiens[22]) ? url('/')."/images/photos_bien/".$bien->photosbiens[22]->filename : "")."!#"   //#265 Photo 22
                  .( isset($bien->photosbiens[23]) ? url('/')."/images/photos_bien/".$bien->photosbiens[23]->filename : "")."!#"   //#266 Photo 23
                  .( isset($bien->photosbiens[24]) ? url('/')."/images/photos_bien/".$bien->photosbiens[24]->filename : "")."!#"   //#267 Photo 24
                  .( isset($bien->photosbiens[25]) ? url('/')."/images/photos_bien/".$bien->photosbiens[25]->filename : "")."!#"   //#268 Photo 25
                  .( isset($bien->photosbiens[26]) ? url('/')."/images/photos_bien/".$bien->photosbiens[26]->filename : "")."!#"   //#269 Photo 26
                  .( isset($bien->photosbiens[27]) ? url('/')."/images/photos_bien/".$bien->photosbiens[27]->filename : "")."!#"   //#270 Photo 27
                  .( isset($bien->photosbiens[28]) ? url('/')."/images/photos_bien/".$bien->photosbiens[28]->filename : "")."!#"   //#271 Photo 28
                  .( isset($bien->photosbiens[29]) ? url('/')."/images/photos_bien/".$bien->photosbiens[29]->filename : "")."!#"   //#272 Photo 29
                  .( isset($bien->photosbiens[30]) ? url('/')."/images/photos_bien/".$bien->photosbiens[30]->filename : "")."!#"   //#273 Photo 30
                  ."!#"   //#274 Titre photo 10
                  ."!#"   //#275 Titre photo 11
                  ."!#"   //#276 Titre photo 12
                  ."!#"   //#277 Titre photo 13
                  ."!#"   //#278 Titre photo 14
                  ."!#"   //#279 Titre photo 15
                  ."!#"   //#280 Titre photo 16
                  ."!#"   //#281 Titre photo 17
                  ."!#"   //#282 Titre photo 18
                  ."!#"   //#283 Titre photo 19
                  ."!#"   //#284 Titre photo 20
                  ."!#"   //#285 Titre photo 21
                  ."!#"   //#286 Titre photo 22
                  ."!#"   //#287 Titre photo 23
                  ."!#"   //#288 Titre photo 24
                  ."!#"   //#289 Titre photo 25
                  ."!#"   //#290 Titre photo 26
                  ."!#"   //#291 Titre photo 27
                  ."!#"   //#292 Titre photo 28
                  ."!#"   //#293 Titre photo 29
                  ."!#"   //#294 Titre photo 30
                  ."!#"   //#295 Prix du terrain
                  ."!#"   //#296 Prix du modèle de maison
                  ."!#"   //#297 Nom de l'agence gérant le terrain
                  ."!#"   //#298 Latitude
                  ."!#"   //#299 Longitude
                  ."!#"   //#300 Précision GPS
                  ."4.08-006!#"   //#301 Version Format
                  ."1!#"   //#302 Honoraires à la charge de
                  ."1200000!#"   //#303 Prix hors honoraires acquéreur
                  ."1!#"   //#304 Modalités charges locataire   ***********
                  ."!#"   //#305 Complément loyer
                  ."300!#"   //#306 Part honoraires état des lieux
               )
               );
               
            }
        }
        
       //  dd($list);
        foreach ($list as $fields) {
            fputcsv($fp, $fields);
        }
        
        fclose($fp);
       // dd($users_biens);

}

}
