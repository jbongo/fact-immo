<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoriquecontratTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historiquecontrats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->nullable();
            // infos basiques 
            $table->double('forfait_entree')->nullable();
            $table->boolean('modif_forfait_entree')->default(false);
            $table->double('forfait_administratif')->nullable();
            $table->boolean('modif_forfait_administratif')->default(false);
            $table->double('forfait_carte_pro')->nullable();
            $table->boolean('modif_forfait_carte_pro')->default(false);
            $table->date('date_entree')->nullable();
            $table->boolean('modif_date_entree')->default(false);
            $table->date('date_deb_activite')->nullable();
            $table->boolean('modif_date_deb_activite')->default(false);
            $table->date('date_anniversaire')->nullable(); // == date_deb_activite + nb_mois_gratuite si starter  ou  == date_deb_activite
            $table->boolean('modif_date_anniversaire')->default(false); // == date_deb_activite + nb_mois_gratuite si starter  ou  == date_deb_activite

            $table->double('ca_depart')->default(0);
            $table->boolean('modif_ca_depart')->default(false);
            $table->double('ca_depart_sty')->default(0);
            $table->boolean('modif_ca_depart_sty')->default(false);
            $table->boolean('est_demarrage_starter')->default(false);
            $table->boolean('modif_est_demarrage_starter')->default(false);
            $table->boolean('a_parrain')->default(false);
            $table->boolean('modif_a_parrain')->default(false);
            $table->integer('parrain_id')->nullable();
            $table->boolean('modif_parrain_id')->default(false);
            $table->boolean('a_condition_parrain')->default(true);
            $table->boolean('modif_a_condition_parrain')->default(false);


// Commission direct pack starter
            $table->double('pourcentage_depart_starter')->nullable();
            $table->boolean('modif_pourcentage_depart_starter')->default(false);
            $table->integer('duree_max_starter')->nullable();
            $table->boolean('modif_duree_max_starter')->default(false);
            $table->integer('duree_gratuite_starter')->nullable();
            $table->boolean('modif_duree_gratuite_starter')->default(false);
            $table->boolean('a_palier_starter')->nullable();
            $table->boolean('modif_a_palier_starter')->default(false);
            $table->text('palier_starter')->nullable();
            $table->boolean('modif_palier_starter')->default(false);

//  Commission direct pack expert
            $table->double('pourcentage_depart_expert')->nullable();
            $table->boolean('modif_pourcentage_depart_expert')->default(false);
            $table->integer('duree_max_starter_expert')->nullable();
            $table->boolean('modif_duree_max_starter_expert')->default(false);
// $table->integer('duree_gratuite_expert')->nullable();
            $table->boolean('a_palier_expert')->nullable();
            $table->boolean('modif_a_palier_expert')->default(false);
            $table->text('palier_expert')->nullable();
            $table->boolean('modif_palier_expert')->default(false);
            $table->integer('nombre_vente_min')->nullable();
            $table->boolean('modif_nombre_vente_min')->default(false);
            $table->integer('nombre_mini_filleul')->nullable();
            $table->boolean('modif_nombre_mini_filleul')->default(false);
            $table->double('chiffre_affaire_mini')->nullable();
            $table->boolean('modif_chiffre_affaire_mini')->default(false);
            $table->double('a_soustraitre')->nullable();
            $table->boolean('modif_a_soustraitre')->default(false);
            $table->boolean('a_condition_expert')->default(true);
            $table->boolean('modif_a_condition_expert')->default(false);
            $table->boolean('est_soumis_tva')->default(true);
            $table->boolean('modif_est_soumis_tva')->default(false);
            $table->boolean('deduis_jeton')->default(true);
            $table->boolean('modif_deduis_jeton')->default(false);


// parrainage
            $table->double('prime_forfaitaire')->nullable();
            $table->boolean('modif_prime_forfaitaire')->default(false);
            $table->double('seuil_comm')->default(1500);
            $table->boolean('modif_seuil_comm')->default(false);
            $table->string('comm_parrain')->nullable();
            $table->boolean('modif_comm_parrain')->default(false);


// Pack pub
            $table->integer('packpub_id')->nullable();
            $table->boolean('modif_packpub_id')->default(false);
            $table->boolean('est_modele')->default(false);
            $table->boolean('modif_est_modele')->default(false);

// Démission
            $table->boolean('a_demission')->default(false);
            $table->boolean('modif_a_demission')->default(false);
            $table->boolean('est_fin_droit_suite')->default(false);
            $table->boolean('modif_est_fin_droit_suite')->default(false);
            $table->date('date_demission')->nullable();
            $table->boolean('modif_date_demission')->default(false);
            $table->date('date_fin_preavis')->nullable();
            $table->boolean('modif_date_fin_preavis')->default(false);
            $table->date('date_fin_droit_suite')->nullable();
            $table->boolean('modif_date_fin_droit_suite')->default(false);
            
            
// Contrat pdf et annexe
            $table->boolean('modif_contrat_pdf')->default(false);
            $table->string('contrat_pdf')->nullable();

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
        Schema::dropIfExists('historiquecontrats');
    }
}
