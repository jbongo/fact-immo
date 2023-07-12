<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nom')->nullable();
            $table->string('prenom')->nullable();
            $table->string('civilite')->nullable();
            $table->string('adresse')->nullable();
            $table->string('complement_adresse')->nullable();
            $table->string('code_postal')->nullable();
            $table->string('ville')->nullable();
            $table->string('pays')->nullable();
            $table->string('telephone1')->nullable();
            $table->string('telephone2')->nullable();
            $table->string('statut')->nullable();
            $table->string('siret')->nullable();
            $table->string('numero_tva')->nullable();
            $table->string('email')->unique();
            $table->string('email_perso')->nullable()->unique();
            $table->enum('role',['admin','mandataire']);
            $table->integer('demande_facture')->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->double('chiffre_affaire')->default(0);
            $table->double('chiffre_affaire_sty')->default(0);
            $table->double('commission')->nullable();
            $table->enum('pack_actuel',['starter','expert'])->nullable();
            $table->integer('nb_mois_pub_restant')->default(12);
            $table->integer('nb_facture_pub_retard')->default(0);            
            $table->string('numero_rsac')->nullable();
            $table->string('code_client')->nullable();
            $table->boolean('is_superviseur')->default(false);
            

            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
