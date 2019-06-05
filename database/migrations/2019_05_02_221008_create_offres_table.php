<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOffresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offres', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->enum('type_offre',['vente','location']);
            $table->text('designation')->nullable();

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
            $table->date('date_mandat')->nullable();

            // Info Partage
            $table->boolean('est_partage_agent')->default(false);
            $table->string('nom_agent')->nullable();
            $table->double('pourcentage_agent')->nullable();
            $table->double('montant_deduis_net')->nullable();

            // Autres Infos
            $table->string('charge')->nullable();
            $table->double('net_vendeur')->nullable();
            $table->string('scp_notaire')->nullable();
            $table->date('date_vente')->nullable();

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
        Schema::dropIfExists('offres');
    }
}
