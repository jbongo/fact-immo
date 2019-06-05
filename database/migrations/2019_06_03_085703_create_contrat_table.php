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
            // infos basiques
            $table->string('forfait_entree')->nullable();
            $table->date('date_entree')->nullable();
            $table->date('date_deb_activite')->nullable();
            $table->boolean('est_demarrage_starter')->default(false);
            $table->boolean('a_parrain')->default(false);
            $table->integer('parrain_id')->nullable();

            // Commission direct
            $table->string('type_plan')->nullable();
            $table->double('pourcentage_depart')->nullable();
            $table->integer('duree_max_starter')->nullable();
            $table->integer('duree_gratuite')->nullable();
            // pack expert
            $table->integer('nombre_vente_min')->nullable();
            $table->integer('nombre_mini_filleul')->nullable();
            $table->double('chiffre_affaire')->nullable();
            $table->double('a_soustraitre')->nullable();


            // parrainage
            $table->double('prime_forfaitaire')->nullable();
            $table->double('pourcentage_annee_un')->nullable();

            // Tarif et abonnement
            $table->double('tarif_mensuel')->nullable();
            $table->integer('nombre_annonce')->nullable();

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
