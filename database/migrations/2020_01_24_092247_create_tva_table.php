<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTvaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tvas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->double('tva_actuelle')->nullable();
            $table->date('date_debut_tva_actuelle')->nullable();
            $table->date('date_fin_tva_actuelle')->nullable();
            $table->double('tva_prochaine')->nullable();
            $table->date('date_debut_tva_prochaine')->nullable();
         
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
        Schema::dropIfExists('tva');
    }
}
