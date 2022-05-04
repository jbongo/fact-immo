<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOutilfichesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outilfiches', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('ficheinfo_id')->nullable();
            $table->integer('outilinfo_id')->nullable();
            $table->string('nom')->nullable();
            $table->string('identifiant')->nullable();
            $table->string('password')->nullable();
            $table->string('site_web')->nullable();
            $table->text('autre_champ')->nullable();
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
        Schema::dropIfExists('outilfiches');
    }
}
