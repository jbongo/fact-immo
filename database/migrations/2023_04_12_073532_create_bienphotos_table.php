<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBienphotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bienphotos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('bien_id');
            $table->integer('annonce_id')->nullable();
            $table->boolean('is_annonce')->default(false);
            $table->string('visibilite');
            $table->text('filename');
            $table->text('resized_name');
            $table->text('original_name');
            $table->integer('image_position');  
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
        Schema::dropIfExists('bienphotos');
    }
}
