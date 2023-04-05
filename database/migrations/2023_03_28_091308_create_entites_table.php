<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entites', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('forme_juridique')->nullable();
            $table->string('raison_sociale')->nullable();
            $table->string('adresse')->nullable();
            $table->string('code_postal')->nullable();
            $table->string('ville')->nullable();
            $table->string('telephone')->nullable();
            $table->string('email')->nullable();
            $table->string('numero_siret')->nullable();
            $table->string('code_naf')->nullable();
            $table->date('date_immatriculation')->nullable();
            $table->string('numero_rsac')->nullable();
            $table->string('numero_assurance')->nullable();
            $table->string('numero_tva')->nullable();
            $table->string('numero_rcs')->nullable();
            $table->string('rib_bancaire')->nullable();
            $table->string('iban')->nullable();
            $table->string('bic')->nullable();
            $table->boolean('archive')->default(0);
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
        Schema::dropIfExists('entites');
    }
}
