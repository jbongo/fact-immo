<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContratTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contrats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->nullable();
            // infos basiques 
            $table->double('forfait_entree')->nullable();
            $table->double('forfait_administratif')->nullable();
            $table->double('forfait_carte_pro')->nullable();
            $table->date('date_entree')->nullable();
            $table->date('date_deb_activite')->nullable();
            $table->double('ca_depart')->default(0);
            $table->double('ca_depart_sty')->default(0);
            $table->boolean('est_demarrage_starter')->default(false);
            $table->boolean('a_parrain')->default(false);
            $table->integer('parrain_id')->nullable();
            $table->boolean('a_condition_parrain')->default(true);

            
            // Commission direct pack starter
            $table->double('pourcentage_depart_starter')->nullable();
            $table->integer('duree_max_starter')->nullable();
            $table->integer('duree_gratuite_starter')->nullable();
            $table->boolean('a_palier_starter')->nullable();
            $table->text('palier_starter')->nullable();

            //  Commission direct pack expert
            $table->double('pourcentage_depart_expert')->nullable();
            $table->integer('duree_max_starter_expert')->nullable();
            // $table->integer('duree_gratuite_expert')->nullable();
            $table->boolean('a_palier_expert')->nullable();
            $table->text('palier_expert')->nullable();
            $table->integer('nombre_vente_min')->nullable();
            $table->integer('nombre_mini_filleul')->nullable();
            $table->double('chiffre_affaire_mini')->nullable();
            $table->double('a_soustraitre')->nullable();
            $table->boolean('a_condition_expert')->default(true);
            $table->boolean('est_soumis_tva')->default(true);
            $table->boolean('deduis_jeton')->default(true);

            
            // parrainage
            $table->double('prime_forfaitaire')->nullable();
            $table->double('seuil_comm')->default(1500);
            $table->string('comm_parrain')->default('a:18:{s:5:"p_1_1";s:1:"5";s:5:"p_1_2";s:1:"5";s:5:"p_1_3";s:1:"5";s:5:"p_1_n";s:1:"5";s:5:"p_2_1";s:1:"3";s:5:"p_2_2";s:1:"4";s:5:"p_2_3";s:1:"5";s:5:"p_2_n";s:1:"5";s:5:"p_3_1";s:1:"1";s:5:"p_3_2";s:1:"3";s:5:"p_3_3";s:1:"5";s:5:"p_3_n";s:1:"5";s:12:"seuil_parr_1";s:1:"0";s:12:"seuil_fill_1";s:1:"0";s:12:"seuil_parr_2";s:5:"30000";s:12:"seuil_fill_2";s:5:"15000";s:12:"seuil_parr_3";s:5:"30000";s:12:"seuil_fill_3";s:5:"30000";}');

        
            // Pack pub
            $table->integer('packpub_id')->nullable();
            $table->boolean('est_modele')->default(false);

            // Démission
            $table->boolean('a_demission')->default(false);
            $table->date('date_demission')->nullable();
            $table->date('date_fin_preavis')->nullable();
            $table->date('date_fin_droit_suite')->nullable();


    
            


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
        Schema::dropIfExists('contrat');
    }
}
