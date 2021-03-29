<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoriquearticleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historiquearticles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('article_id')->nullable();
            
            $table->string('libelle')->nullable();
            $table->boolean('modif_libelle')->default(false);
            
            $table->integer('quantite')->nullable();
            $table->boolean('modif_quantite')->default(false);
            
            $table->double('prix_achat')->nullable();
            $table->boolean('modif_prix_achat')->default(false);
            
            $table->double('coefficient')->nullable();
            $table->boolean('modif_coefficient')->default(false);
            
            $table->integer('fournisseur_id')->nullable();
            $table->boolean('modif_fournisseur_id')->default(false);
            
            $table->date('date_achat')->nullable();
            $table->boolean('modif_date_achat')->default(false);
            
            $table->date('date_expiration')->nullable();
            $table->boolean('modif_date_expiration')->default(false);
            
            $table->boolean('a_expire')->default(false);
            $table->boolean('modif_a_expire')->default(false);
            
            $table->string('description')->nullable();
            $table->boolean('modif_description')->default(false);
            
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
        Schema::dropIfExists('historiquearticle');
    }
}
