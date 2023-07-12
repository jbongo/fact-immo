<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBiendetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('biendetails', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('bien_id');
            $table->string('particularite_particularite')->nullable();
            $table->integer('agen_inter_nb_chambre')->nullable();
            $table->integer('agen_inter_nb_salle_bain')->nullable();
            $table->integer('agen_inter_nb_salle_eau')->nullable();
            $table->integer('agen_inter_nb_wc')->nullable();
            $table->integer('agen_inter_nb_lot')->nullable();
            $table->integer('agen_inter_nb_couchage')->nullable();

            $table->string('agen_inter')->nullable();
            $table->integer('agen_inter_nb_niveau')->nullable();
            $table->string('agen_inter_grenier_comble')->nullable();
            $table->string('agen_inter_buanderie')->nullable();
            $table->string('agen_inter_meuble')->nullable();
            $table->double('agen_inter_surface_carrez')->nullable();
            $table->double('agen_inter_surface_habitable')->nullable();
            $table->double('agen_inter_surface_sejour')->nullable();
            $table->string('agen_inter_cuisine_type')->nullable();
            $table->string('agen_inter_cuisine_etat')->nullable();
            $table->string('agen_inter_situation_exposition')->nullable();
            $table->string('agen_inter_situation_vue')->nullable();
            $table->string('agen_exter_mitoyennete')->nullable();
            $table->string('agen_exter_etage')->nullable();
            $table->string('agen_exter_terrasse')->nullable();
            $table->integer('agen_exter_nb_terrasse')->nullable();
            $table->double('agen_exter_surface_terrasse')->nullable();
            $table->string('agen_exter_plain_pied')->nullable();
            $table->string('agen_exter_sous_sol')->nullable();
            $table->double('agen_exter_surface_jardin')->nullable();
            $table->string('agen_exter_privatif_jardin')->nullable();
            $table->string('agen_exter_type_cave')->nullable();
            $table->double('agen_exter_surface_cave')->nullable();
            $table->string('agen_exter_balcon')->nullable();
            $table->integer('agen_exter_nb_balcon')->nullable();
            $table->double('agen_exter_surface_balcon')->nullable();
            $table->string('agen_exter_loggia')->nullable();
            $table->double('agen_exter_surface_loggia')->nullable();
            $table->string('agen_exter_veranda')->nullable();
            $table->double('agen_exter_surface_veranda')->nullable();
            $table->integer('agen_exter_nb_garage')->nullable();
            $table->double('agen_exter_surface_garage')->nullable();
            $table->string('agen_exter_parking_interieur')->nullable();
            $table->string('agen_exter_parking_exterieur')->nullable();
            $table->string('agen_exter_statut_piscine')->nullable();
            $table->double('agen_exter_dimension_piscine')->nullable();
            $table->double('agen_exter_volume_piscine')->nullable();
            $table->double('terrain_surface_terrain')->nullable();
            $table->double('terrain_surface_constructible')->nullable();
            $table->string('terrain_constructible')->nullable();
            $table->string('terrain_topographie')->nullable();
            $table->string('terrain_emprise_au_sol')->nullable();
            $table->string('terrain_emprise_au_sol_residuelle')->nullable();
            $table->string('terrain_shon')->nullable();
            $table->string('terrain_ces')->nullable();
            $table->string('terrain_pos')->nullable();
            $table->string('terrain_codification_plu')->nullable();
            $table->string('terrain_droit_de_passage')->nullable();
            $table->string('terrain_reference_cadastrale')->nullable();
            $table->string('terrain_piscinable')->nullable();
            $table->string('terrain_arbore')->nullable();
            $table->string('terrain_viabilise')->nullable();
            $table->string('terrain_cloture')->nullable();
            $table->string('terrain_divisible')->nullable();
            $table->string('terrain_possiblite_egout')->nullable();
            $table->string('terrain_info_copopriete')->nullable();
            $table->string('terrain_acces')->nullable();
            $table->string('terrain_raccordement_eau')->nullable();
            $table->string('terrain_raccordement_gaz')->nullable();
            $table->string('terrain_raccordement_electricite')->nullable();
            $table->string('terrain_raccordement_telephone')->nullable();
            $table->text('equipement_format')->nullable();
            $table->text('equipement_type')->nullable();
            $table->text('equipement_energie')->nullable();
            $table->text('equipement_ascenseur')->nullable();
            $table->text('equipement_acces_handicape')->nullable();
            $table->text('equipement_climatisation')->nullable();
            $table->text('equipement_climatisation_specification')->nullable();
            $table->text('equipement_eau_alimentation')->nullable();
            $table->text('equipement_eau_assainissement')->nullable();
            $table->text('equipement_eau_chaude_distribution')->nullable();
            $table->text('equipement_eau_chaude_energie')->nullable();
            $table->text('equipement_cheminee')->nullable();
            $table->text('equipement_arrosage')->nullable();
            $table->text('equipement_barbecue')->nullable();
            $table->text('equipement_tennis')->nullable();
            $table->text('equipement_local_a_velo')->nullable();
            $table->text('equipement_volet_electrique')->nullable();
            $table->text('equipement_gardien')->nullable();
            $table->text('equipement_double_vitrage')->nullable();
            $table->text('equipement_triple_vitrage')->nullable();
            $table->text('equipement_cable')->nullable();
            $table->text('equipement_securite_porte_blinde')->nullable();
            $table->text('equipement_securite_interphone')->nullable();
            $table->text('equipement_securite_visiophone')->nullable();
            $table->text('equipement_securite_alarme')->nullable();
            $table->text('equipement_securite_digicode')->nullable();
            $table->text('equipement_securite_detecteur_de_fumee')->nullable();
            $table->text('equipement_portail_electrique')->nullable();
            $table->text('equipement_cuisine_ete')->nullable();
            $table->integer('diagnostic_annee_construction')->nullable();
            $table->string('diagnostic_dpe_bien_soumi')->nullable();
            $table->string('diagnostic_dpe_vierge')->nullable();
            $table->string('diagnostic_dpe_consommation')->nullable();
            $table->string('diagnostic_dpe_ges')->nullable();
            $table->date('diagnostic_dpe_date')->nullable();
            $table->string('diagnostic_etat_exterieur')->nullable();
            $table->string('diagnostic_etat_interieur')->nullable();
            $table->double('diagnostic_surface_annexe')->nullable();
            $table->string('diagnostic_etat_parasitaire')->nullable();
            $table->date('diagnostic_etat_parasitaire_date')->nullable();
            $table->text('diagnostic_etat_parasitaire_commentaire')->nullable();
            $table->string('diagnostic_amiante')->nullable();
            $table->date('diagnostic_amiante_date')->nullable();
            $table->text('diagnostic_amiante_commentaire')->nullable();
            $table->string('diagnostic_electrique')->nullable();
            $table->date('diagnostic_electrique_date')->nullable();
            $table->text('diagnostic_electrique_commentaire')->nullable();
            $table->string('diagnostic_loi_carrez')->nullable();
            $table->date('diagnostic_loi_carrez_date')->nullable();
            $table->text('diagnostic_loi_carrez_commentaire')->nullable();
            $table->string('diagnostic_risque_nat')->nullable();
            $table->date('diagnostic_risque_nat_date')->nullable();
            $table->text('diagnostic_risque_nat_commentaire')->nullable();
            $table->string('diagnostic_plomb')->nullable();
            $table->date('diagnostic_plomb_date')->nullable();
            $table->string('diagnostic_plomb_commentaire')->nullable();
            $table->string('diagnostic_gaz')->nullable();
            $table->date('diagnostic_gaz_date')->nullable();
            $table->string('diagnostic_gaz_commentaire')->nullable();
            $table->string('diagnostic_assainissement')->nullable();
            $table->date('diagnostic_assainissement_date')->nullable();
            $table->string('diagnostic_assainissement_commentaire')->nullable();
            
            $table->string('copropriete_bien_en')->nullable();
            $table->string('copropriete_numero_lot')->nullable();
            $table->string('copropriete_nombre_lot')->nullable();
            $table->string('copropriete_quote_part_charge')->nullable();
            $table->double('copropriete_montant_fond_travaux')->nullable();
            $table->string('copropriete_plan_sauvegarde')->nullable();
            $table->string('copropriete_statut_syndic')->nullable();
            $table->string('dossier_dispo_numero')->nullable();
            $table->date('dossier_dispo_dossier_cree_le')->nullable();
            $table->string('dossier_dispo_disponibilite_immediate')->nullable();
            $table->date('dossier_dispo_disponible_le')->nullable();
            $table->date('dossier_dispo_liberation_le')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('biendetails');
    }
}