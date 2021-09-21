<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBanquesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banques', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->string('numero_facture')->nullable();
            $table->text('libelle')->nullable();
            $table->date('date_encaissement')->nullable();
            $table->double('montant')->nullable();
            $table->boolean('encaissee')->default(false);
            $table->boolean('traitee')->default(false);
            $table->boolean('doublon')->default(false);
            
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
        Schema::dropIfExists('banques');
    }
}
