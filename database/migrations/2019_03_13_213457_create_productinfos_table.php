<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductinfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productinfos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('product_id');
            $table->boolean('is_engagement')->nullable();
            $table->integer('eng_like')->nullable();
            $table->integer('eng_comment')->nullable();
            $table->integer('eng_share')->nullable();
            $table->integer('eng_reaction')->nullable();
            $table->boolean('is_link')->nullable();
            $table->string('link_aliexpress')->nullable();
            $table->string('link_alibaba')->nullable();
            $table->string('link_facebookAd')->nullable();
            $table->string('link_amazon')->nullable();
            $table->string('link_ebay')->nullable();
            $table->boolean('is_analytic')->nullable();
            $table->string('analy_source')->nullable();
            $table->integer('analy_order')->nullable();
            $table->integer('analy_vote')->nullable();
            $table->integer('analy_review')->nullable();
            $table->double('analy_rating')->nullable();
            $table->boolean('is_profit')->nullable();
            $table->double('cpa_min')->nullable();
            $table->double('cpa_max')->nullable();
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
        Schema::dropIfExists('productinfos');
    }
}
