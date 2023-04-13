<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndividusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('individus', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('contact_id')->unsigned()->nullable();
            $table->string('civilite')->nullable();
            $table->string('nom')->nullable();
            $table->string('prenom')->nullable();
            $table->date('date_naissance')->nullable();
            $table->string('lieu_naissance')->nullable();
            $table->string('nationalite')->nullable();
            $table->string('prenom_pere')->nullable();
            $table->string('nom_prenom_mere')->nullable();
            $table->string('situation_matrimoniale')->nullable();
            $table->string('nom_jeune_fille')->nullable();
            $table->string('adresse')->nullable();
            $table->string('code_postal')->nullable();
            $table->string('ville')->nullable();
            $table->string('telephone_fixe')->nullable();
            $table->string('telephone_mobile')->nullable();
            $table->string('email')->nullable();
            
            $table->string('civilite1')->nullable();
            $table->string('nom1')->nullable();
            $table->string('prenom1')->nullable();
            $table->string('adresse1')->nullable();
            $table->string('code_postal1')->nullable();
            $table->string('ville1')->nullable();
            $table->string('telephone_fixe1')->nullable();
            $table->string('telephone_mobile1')->nullable();
            $table->string('email1')->nullable();
            
            $table->string('civilite2')->nullable();
            $table->string('nom2')->nullable();
            $table->string('prenom2')->nullable();
            $table->string('adresse2')->nullable();
            $table->string('code_postal2')->nullable();
            $table->string('ville2')->nullable();
            $table->string('telephone_fixe2')->nullable();
            $table->string('telephone_mobile2')->nullable();
            $table->string('email2')->nullable();
            
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
        Schema::dropIfExists('individus');
    }
}
