<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBienContactTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bien_contact', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('bien_id')->nullable();
            $table->integer('contact_id')->nullable();
            // Propriétaire, Acquéreur, Notaire, etc
            $table->string('role_contact')->nullable();
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
        Schema::dropIfExists('bien_contact');
    }
}
