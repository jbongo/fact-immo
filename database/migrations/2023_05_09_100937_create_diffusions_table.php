<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiffusionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diffusions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('bien_id')->unsigned();
            // 'automatique','planifie'
            $table->string('type')->default('automatique');
            $table->integer('passerelle_id')->nullable();
            $table->integer('annonce_id')->nullable();
            $table->integer('date')->nullable();
            $table->integer('date_debut')->nullable();
            $table->integer('date_fin')->nullable();
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
        Schema::dropIfExists('diffusions');
    }
}
