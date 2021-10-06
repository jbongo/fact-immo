<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoriquefichiersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historiquefichiers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->nullable();
            $table->integer('document_id')->nullable();
            $table->string('url')->nullable();
            $table->boolean('modif_url')->default(false);
            $table->date('date_expiration')->nullable();
            $table->boolean('modif_date_expiration')->default(false);
            $table->string('extension')->nullable();
            $table->boolean('modif_extension')->default(false);
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
        Schema::dropIfExists('historiquefichiers');
    }
}
