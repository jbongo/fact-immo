<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('libelle')->nullable();
            $table->integer('quantite')->nullable();
            $table->double('prix_achat')->nullable();
            $table->double('coefficient')->nullable();
            $table->integer('fournisseur_id')->nullable();
            $table->date('date_achat')->nullable();
            $table->boolean('a_expire')->default(false);
            $table->string('description')->nullable();

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
        Schema::dropIfExists('articles');
    }
}
