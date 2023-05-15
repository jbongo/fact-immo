<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOffreachatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offreachats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('bien_id')->unsigned()->nullable();
            $table->integer('acquereur_id')->nullable();
            $table->integer('notaire_id')->nullable();
            $table->double('montant')->unsigned()->nullable();
            $table->double('frais_agence')->unsigned()->nullable();
            $table->date('date_debut')->nullable();
            $table->date('date_expiration')->nullable();
            // 'vendeur', 'acquereur'
            $table->string('charge')->default('acquereur');
            // 'En cours', 'Compromis', 'Annulée', 'Non retenue', 'Rejetée'
            $table->string('statut')->default('En cours');
            $table->text('conditions_suspensives')->nullable();
            $table->boolean('annulation')->default(false);
            $table->string('fichier_pdf')->nullable();
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
        Schema::dropIfExists('offreachats');
    }
}
