<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProspectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prospects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nom')->nullable();
            $table->string('nom_usage')->nullable();
            $table->string('prenom')->nullable();
            $table->string('civilite')->nullable();
            $table->string('adresse')->nullable();
            $table->string('code_postal')->nullable();
            $table->string('ville')->nullable();
            $table->string('telephone_fixe')->nullable();
            $table->string('telephone_portable')->nullable();
            $table->string('email')->unique();
            
            
            
            $table->date('date_naissance')->nullable();
            $table->string('lieu_naissance')->nullable();
            $table->integer('departement_naissance')->nullable();
            $table->string('situation_familliale')->nullable();
            $table->string('nationalite')->nullable();
            $table->string('nom_pere')->nullable();
            $table->string('nom_mere')->nullable();
            
            $table->enum('statut_souhaite',['auto-entrepreneur','portage salarial','independant', 'autre']);
            $table->string('numero_rsac')->nullable();
            $table->string('numero_siret')->nullable();
            
            $table->text('code_postaux')->nullable();
            $table->string('piece_identite')->nullable();
            $table->string('rib')->nullable();
            $table->string('attestation_responsabilite')->nullable();
            $table->string('photo')->nullable();
            $table->boolean('a_parrain')->default(false);
            $table->string('nom_parrain')->nullable();
            
            $table->boolean('archive')->default(false);
            $table->boolean('renseigne')->default(false);
            $table->boolean('a_ouvert_fiche')->default(false);
            $table->date('date_ouverture_fiche')->nullable();
            $table->boolean('fiche_envoyee')->default(false);
            $table->boolean('modele_contrat_envoye')->default(false);
            $table->boolean('contrat_envoye')->default(false);
            $table->boolean('est_mandataire')->default(false);
            
            $table->text('commentaire_perso')->nullable();
            $table->text('commentaire_pro')->nullable();
            
            
            // id mandataire lorsque que le prospect devient mandataire 
            $table->integer('user_id')->nullable();
            
    
            
            
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
        Schema::dropIfExists('prospects');
    }
}
