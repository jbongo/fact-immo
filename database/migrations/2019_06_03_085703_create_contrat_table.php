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

            
            // parrainage
            $table->double('prime_forfaitaire')->nullable();

            // Pack pub
            $table->integer('packpub_id')->nullable();

            $table->boolean('est_modele')->default(false);

            
            


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
