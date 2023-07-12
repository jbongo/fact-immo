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
            $table->integer('contact_id')->nullable();
            $table->double('montant')->unsigned()->nullable();
            $table->double('frais_agence')->unsigned()->nullable();
            $table->date('date_debut')->nullable();
            $table->date('date_expiration')->nullable();          
            // 0 = en attente de validation 1 = acceptée , 2 = réfusée
            $table->integer('statut')->default(0);
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
