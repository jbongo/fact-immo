<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMandatsTable extends Migration
{
    /**
     * Run the migrations.
     *s
     * @return void
     */
    public function up()
    {
        Schema::create('mandats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('numero')->nullable();
            $table->string('nom_reservation')->nullable();
            $table->string('type')->nullable(); // Vente, Achat, recherche etc.
            $table->string('nature')->nullable(); // Simple, Exclusif...
            $table->integer('user_id')->unsigned()->nullable(); // mandataire qui saisi
            $table->integer('suivi_par_id')->unsigned()->nullable(); // mandataire qui suit l'affaire
            $table->integer('contact_id')->nullable(); // mandant
            $table->integer('bien_id')->unsigned()->nullable();
            $table->string('statut')->nullable('mandat'); // reservation, mandat
            $table->date('date_debut')->nullable();
            $table->date('date_fin')->nullable();
            $table->integer('duree_tacite_reconduction')->nullable();
            $table->integer('duree_irrevocabilite')->nullable();
            $table->boolean('annulation')->default(false);
            $table->text('motif_annulation')->nullable();
            $table->boolean('est_cloture')->default(false);
            $table->text('motif_cloture')->nullable();
            $table->date('date_cloture')->nullable();
            $table->boolean('est_retourne')->default(false)->nullable();
            $table->date('date_retour')->nullable();
            $table->text('observation')->nullable();          
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
