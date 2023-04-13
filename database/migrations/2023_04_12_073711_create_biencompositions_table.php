<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBiencompositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('biencompositions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('bien_id')->unsigned();
            $table->string('piece')->nullable();
            $table->text('detail')->nullable();
            $table->double('surface')->nullable();
            $table->text('note')->nullable();
            $table->string('est_privee')->nullable();
            $table->string('est_publique')->nullable();
            $table->string('est_inter_agence')->nullable();
            $table->integer('nombre_etage')->nullable();
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
        Schema::dropIfExists('biencompositions');
    }
}
