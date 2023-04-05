<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMandatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mandats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('type', ['recherche', 'vente']);
            $table->integer('users_id')->unsigned();
            $table->integer('biens_id')->unsigned()->unique()->nullable();
            $table->integer('contact_id')->unsigned()->nullable();
            $table->string('numero')->unique();
            $table->enum('nature', ['exclusif', 'semi-exclusif','simple']);
            $table->enum('statut', ['clos', 'expiré', 'actif'])->default('actif');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->boolean('annulation')->default(0);
            $table->string('raison_annulation')->nullable();
            $table->text('note_annulation')->nullable();
            $table->text('note')->nullable();
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
        Schema::dropIfExists('mandats');
    }
}
