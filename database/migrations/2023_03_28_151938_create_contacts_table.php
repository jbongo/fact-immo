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
            $table->integer('user_id')->unsigned()->nullable();
            
            // Entite ou individu
            $table->string("type")->nullable();         
            $table->enum('nature', ['personne_seule', 'couple', 'personne_morale', 'groupe', 'autre'])->default('autre');
            
            $table->boolean("est_partenaire")->default(false);
            $table->boolean("est_acquereur")->default(false);
            $table->boolean("est_proprietaire")->default(false);
            $table->boolean("est_locataire")->default(false);
            $table->boolean("est_notaire")->default(false);
            $table->boolean("est_prospect")->default(false);
            $table->boolean("est_fournisseur")->default(false);
            
            $table->boolean("archive")->default(false);
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
