<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBaremehonorairesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('baremehonoraires', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->double('prix_min')->nullable();
            $table->double('prix_max')->nullable();
            $table->double('forfait_min')->nullable();
            $table->double('forfait_max')->nullable();
            $table->double('pourcentage')->nullable();
            $table->boolean('est_forfait')->default(false);
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
        Schema::dropIfExists('baremehonoraires');
    }
}
