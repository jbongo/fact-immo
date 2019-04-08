<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductpicturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productpictures', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('filename');
            $table->integer('product_id');
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
        Schema::dropIfExists('productpictures');
    }
}
