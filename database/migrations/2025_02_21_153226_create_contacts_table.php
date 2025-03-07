<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->nullable();
            $table->string('type_contact')->nullable();
            $table->string('civilite')->nullable();
            $table->string('nom')->nullable();
            $table->string('prenom')->nullable();
            $table->string('telephone')->nullable();
            $table->string('email')->nullable();
            $table->string('adresse')->nullable();
            $table->string('code_postal')->nullable();
            $table->string('ville')->nullable();
            $table->string('type_entreprise')->nullable();
            $table->string('raison_sociale')->nullable();
            $table->string('nom_indivision')->nullable();
            $table->string('nom_p1')->nullable();
            $table->string('prenom_p1')->nullable();
            $table->string('telephone_p1')->nullable();
            $table->string('email_p1')->nullable();
            $table->string('adresse_p1')->nullable();
            $table->string('code_postal_p1')->nullable();
            $table->string('ville_p1')->nullable();
            $table->string('nom_p2')->nullable();
            $table->string('prenom_p2')->nullable();
            $table->string('telephone_p2')->nullable();
            $table->string('email_p2')->nullable();
            $table->string('adresse_p2')->nullable();
            $table->string('code_postal_p2')->nullable();
            $table->string('ville_p2')->nullable();
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
        Schema::dropIfExists('contacts');
    }
}
