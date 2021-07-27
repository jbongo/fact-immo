<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFactureTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factures', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('numero')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('filleul_id')->nullable();
            $table->integer('facture_id')->nullable();
            $table->text('motif')->nullable();
            $table->integer('compromis_id')->nullable();
            $table->enum('type',['stylimmo','honoraire','pack_pub','carte_visite','parrainage','partage','partage_externe','parrainage_partage','communication','autre'])->nullable();
            $table->boolean('encaissee')->default(false);
            $table->date('date_encaissement')->nullable();
            $table->boolean('reglee')->default(false);
            $table->date('date_reglement')->nullable();
            $table->double('montant_ht')->nullable();
            $table->double('montant_ttc')->nullable();
            $table->integer('nb_mois_deduis')->nullable();
            $table->string('url')->nullable();
            $table->text('formule')->nullable();
            $table->boolean('a_avoir')->default(false);
            $table->date('date_facture')->nullable();
            $table->enum('statut',['non valide','en attente de validation','refuse','valide'])->default('non valide');

            // annexe facture (libre)
            $table->boolean('destinataire_est_mandataire')->default(true);
            $table->text('destinataire')->nullable();
            $table->text('description_produit')->nullable();
            
            $table->date('date_relance_paiement')->nullable();
            $table->integer('nb_relance_paiement')->default(0);
            

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
        Schema::dropIfExists('facture');
    }
}
