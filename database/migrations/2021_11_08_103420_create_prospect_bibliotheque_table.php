<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProspectBibliothequeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prospect_bibliotheque', function (Blueprint $table) {
            $table->bigIncrements('id');
           
            $table->integer('prospect_id')->nullable();
            $table->integer('bibliotheque_id')->nullable();           
            $table->boolean('est_fichier_vu')->default(false);
            // questions à poser à l'utilisateur
            $table->string('question1')->nullable();
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
        Schema::dropIfExists('prospect_bibliotheque');
    }
}
