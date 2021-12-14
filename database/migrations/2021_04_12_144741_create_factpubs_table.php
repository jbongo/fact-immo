<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFactpubsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factpubs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->nullable();
            $table->integer('facture_id')->nullable();
            
            $table->string('packpub')->nullable();
            $table->double('montant_ht')->nullable();
            $table->double('montant_ttc')->nullable();
            
            // 0 = en attente, 1 = accepté 2 = refusé
            $table->integer('validation')->default(0);
            
            $table->date('date_validation')->nullable();
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
        Schema::dropIfExists('factpubs');
    }
}
