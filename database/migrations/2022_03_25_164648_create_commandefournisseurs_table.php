<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommandefournisseursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commandefournisseurs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('fournisseur_id')->nullable();          
            $table->string('numero_commande')->nullable();
            $table->text('description')->nullable();           
            $table->date('date_commande')->nullable();
         
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
        Schema::dropIfExists('commandefournisseurs');
    }
}
