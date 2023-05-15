<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visites', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('bien_id')->unsigned()->nullable();
            // le visiteur
            $table->integer('contact_id')->unsigned()->nullable();
            $table->date('date')->nullable();
            $table->time('heure')->nullable();
            // 'Préparation', 'Effectuée', 'Annulée'
            $table->string('etat')->nullable();
            $table->text('compte_rendu')->nullable();
            $table->string('bon_de_visite')->nullable();
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
        Schema::dropIfExists('visites');
    }
}
