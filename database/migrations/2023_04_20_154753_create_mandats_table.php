<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMandatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mandats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('bien_id')->unsigned()->nullable();
            // Le contact ici c'est le propriétaire du bien
            $table->integer('proprietaire_id')->unsigned()->nullable();
            // exclusif', 'semi-exclusif','simple'
            $table->string('type')->nullable();
            // recherche ou vente
            $table->string('nature')->default('vente');
            $table->string('numero')->nullable();
          
            // 'clos', 'expiré', 'actif'
            $table->string('statut')->default('actif');
            $table->date('date_debut')->nullable();
            $table->date('date_fin')->nullable();
            $table->boolean('annulation')->default(0);
            $table->string('raison_annulation')->nullable();
            $table->string('duree_irrevocabilite')->nullable();
            $table->text('note_annulation')->nullable();
            $table->text('note')->nullable();
            $table->boolean('est_archive')->default(false);
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
        Schema::dropIfExists('mandats');
    }
}
