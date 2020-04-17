<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompromisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compromis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->enum('type_affaire',['Vente','Location']);
            $table->text('description_bien')->nullable();
            $table->text('code_postal_bien')->nullable();
            $table->string('ville_bien')->nullable();

            // Infos propriétaire / Vendeur
            $table->string('civilite_vendeur')->nullable();
            $table->string('nom_vendeur')->nullable();
            $table->string('prenom_vendeur')->nullable();
            $table->string('adresse1_vendeur')->nullable();
            $table->string('adresse2_vendeur')->nullable();
            $table->string('code_postal_vendeur')->nullable();
            $table->string('ville_vendeur')->nullable();

            // Infos Locataire / Acquéreur
            $table->string('civilite_acquereur')->nullable();
            $table->string('nom_acquereur')->nullable();
            $table->string('prenom_acquereur')->nullable();
            $table->string('adresse1_acquereur')->nullable();
            $table->string('adresse2_acquereur')->nullable();
            $table->string('code_postal_acquereur')->nullable();
            $table->string('ville_acquereur')->nullable();

            // Infos Mandat
            $table->string('numero_mandat')->nullable();
            $table->string('numero_mandat_porte_pas')->nullable(); // mandat renseigné par celui qui ne porte l'affaire
            $table->date('date_mandat')->nullable(); 

            // Info Partage
            $table->boolean('est_partage_agent')->default(false);
            $table->string('nom_agent')->nullable();
            $table->double('pourcentage_agent')->nullable();
            $table->double('montant_deduis_net')->nullable();

            // Autres Infos
            $table->string('charge')->nullable();
            $table->double('net_vendeur')->nullable();
            $table->double('frais_agence')->nullable();
            $table->string('scp_notaire')->nullable();
            $table->date('date_vente')->nullable();
            $table->date('date_signature')->nullable();
            
            // demande facture
        // 0 = facture non demandée, 1= facture demandée en attente de validation, 2 = demande traitée par stylimmo
            $table->boolean('demande_facture')->default(false); 

            $table->integer('agent_id')->nullable(); 
            $table->integer('parrain_partage_id')->nullable(); 
            $table->boolean('je_porte_affaire')->default(false); 
            $table->boolean('je_renseigne_affaire')->default(true); 
            $table->boolean('partage_reseau')->default(false); 
            $table->string('raison_sociale_acquereur')->nullable(); 
            $table->string('raison_sociale_vendeur')->nullable(); 
            
            $table->boolean('facture_stylimmo_valide')->default(false);
            $table->boolean('facture_honoraire_cree')->default(false);
            $table->boolean('facture_honoraire_parrainage_cree')->default(false);
            $table->boolean('facture_honoraire_parrainage_partage_cree')->default(false);
            $table->boolean('facture_honoraire_partage_cree')->default(false);
            $table->boolean('facture_honoraire_partage_porteur_cree')->default(false);
            $table->boolean('cloture_affaire')->default(false);
            $table->text('observations')->nullable(); 
            $table->string('pdf_compromis')->nullable(); 
            $table->boolean('archive')->default(false);
            $table->string('motif_archive')->nullable();


            
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
        Schema::dropIfExists('compromis');
    }
}
