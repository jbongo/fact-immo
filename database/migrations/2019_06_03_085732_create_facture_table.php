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
            $table->integer('compromis_id')->nullable();
            $table->enum('type',['stylimmo','honoraire','pack_pub','carte_visite','parrainage','partage'])->nullable();
            $table->boolean('encaissee')->default(false);
            $table->double('montant_ht')->nullable();
            $table->double('montant_ttc')->nullable();
            $table->integer('nb_mois_deduis')->nullable();
            $table->string('url')->nullable();
            $table->text('formule')->nullable();
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
