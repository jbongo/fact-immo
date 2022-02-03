<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFichiersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fichiers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->nullable();
            $table->integer('document_id')->nullable();
            $table->string('url')->nullable();
            $table->date('date_expiration')->nullable();
            $table->string('extension')->nullable();
            // 0 = en attente de validation, 1 = validé, 2 = refusé
            $table->boolean('valide')->default(0);
            $table->boolean('expire')->default(false);
            $table->string('motif_refu')->nullable();
            
            
            
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
        Schema::dropIfExists('fichiers');
    }
}
