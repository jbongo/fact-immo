<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParametreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parametres', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('tva_id')->nullable();
            $table->string('raison_sociale')->nullable();
            $table->string('numero_siret')->nullable();
            $table->string('numero_rcs')->nullable();
            $table->string('numero_tva')->nullable();
            $table->string('adresse')->nullable();
            $table->string('code_postal')->nullable();
            $table->string('ville')->nullable();
            $table->double('ca_imposable')->nullable();
            $table->text('comm_parrain')->nullable();
            $table->integer('nb_jour_max_demande')->nullable();
            $table->double('capital')->nullable();
            $table->string('num_carte_pro')->nullable();
            $table->date('carte_pro_delivre_le')->nullable();
            $table->string('carte_pro_delivre_par')->nullable();
            $table->string('adresse_organisme_de_garantie')->nullable();
            $table->string('gerant')->nullable();
            
            
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
        Schema::dropIfExists('parametre');
    }
}
