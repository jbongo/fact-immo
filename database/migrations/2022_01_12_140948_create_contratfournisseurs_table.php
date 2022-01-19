<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContratfournisseursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contratfournisseurs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('fournisseur_id')->nullable();
            $table->string('libelle')->nullable();             
            $table->string('numero_contrat')->nullable();
            $table->string('numero_client')->nullable();
            $table->text('description')->nullable();            
            $table->date('date_deb')->nullable();
            $table->date('date_fin')->nullable();
            $table->boolean('a_expire')->default(false);
            $table->boolean('archive')->default(false);
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
        Schema::dropIfExists('contratfournisseurs');
    }
}
