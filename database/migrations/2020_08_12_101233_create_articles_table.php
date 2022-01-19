<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('fournisseur_id')->nullable();
            $table->integer('contratfournisseur_id')->nullable();
            $table->string('libelle')->nullable();
            // Annonce - Remontée - Autre
            $table->string('type')->default("autre");                  
            // une fois, mensuelle, trimestruelle, annuelle, autre
            $table->string('periodicite_facturation')->nullable();
            $table->integer('quantite')->nullable();
            $table->double('prix_achat')->nullable();
            $table->double('coefficient')->nullable();
            $table->date('date_achat')->nullable();
            $table->date('date_expiration')->nullable();
            $table->boolean('a_expire')->default(false);
            $table->string('description')->nullable();
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
        Schema::dropIfExists('articles');
    }
}
