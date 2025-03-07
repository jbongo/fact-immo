<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBiensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('biens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->unsigned();
            $table->string('type_offre')->nullable();
            $table->string('type_bien')->nullable();

            $table->string('type_type_bien')->nullable();
            $table->string('titre_annonce')->nullable();
            $table->text('description_annonce')->nullable();
            $table->string('titre_annonce_vitrine')->nullable();
            $table->text('description_annonce_vitrine')->nullable();
            $table->string('titre_annonce_privee')->nullable();
            $table->text('description_annonce_privee')->nullable();
            // adresse
            $table->string('adresse')->nullable();
            $table->string('code_postal')->nullable();
            $table->string('ville')->nullable();
            $table->string('pays')->nullable();

            // loyer
            $table->integer('duree_bail')->nullable();
            $table->string('meuble')->nullable();
            // #
            $table->double('surface')->nullable();
            $table->double('surface_habitable')->nullable();
            $table->double('surface_terrain')->nullable();
            $table->integer('nombre_piece')->nullable();
            $table->integer('nombre_chambre')->nullable();
            $table->integer('nombre_niveau')->nullable();
            $table->string('jardin')->nullable();
            $table->double('jardin_surface')->nullable();
            $table->string('jardin_privatif')->nullable();
            $table->double('jardin_volume')->nullable();
            $table->string('jardin_pool_house')->nullable();
            $table->string('jardin_chauffee')->nullable();
            $table->string('jardin_couverte')->nullable();
            $table->string('piscine')->nullable();
            $table->string('piscine_statut')->nullable();
            $table->string('piscine_nature')->nullable();
            $table->string('numero_dossier')->nullable();
            $table->date('date_creation_dossier')->nullable();
            $table->integer('nombre_garage')->nullable();
            $table->string('exposition_situation')->nullable();
            $table->string('vue_situation')->nullable();
            $table->boolean('mandat_actif')->default(0);
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
        Schema::dropIfExists('biens');
    }
}
