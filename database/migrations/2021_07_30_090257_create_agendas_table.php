<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgendasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agendas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('titre')->nullable();
            $table->string('type_rappel')->nullable();
            $table->text('description')->nullable();
            $table->date('date_deb')->nullable();
            $table->date('date_fin')->nullable();
            $table->string('heure_deb')->nullable();
            $table->string('heure_fin')->nullable();
            $table->boolean('est_agenda_prospect')->default(false);
            $table->boolean('est_agenda_mandataire')->default(false);
            $table->boolean('est_agenda_general')->default(false);
            $table->boolean('est_terminee')->default(false);
            $table->integer('prospect_id')->nullable();
            $table->integer('mandataire_id')->nullable();
            
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
        Schema::dropIfExists('agendas');
    }
}
