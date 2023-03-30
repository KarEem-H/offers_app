<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('title')->nullable();
            $table->longText('slug')->nullable();
            $table->longText('small_description')->nullable();
            $table->string('photo', 255)->nullable();
            $table->longText('meta_keywords')->nullable();
            $table->longText('meta_description')->nullable();
            $table->integer('top_offer')->default(0);
            $table->integer('price')->nullable();
            $table->integer('discount_price')->nullable();
            $table->timestamps();
            $table->string('image_title', 255)->nullable();
            $table->string('image_alt', 255)->nullable();
            $table->integer('order')->nullable();
            $table->longText('offer_note')->nullable();
            $table->boolean('status')->default(1);
            $table->date('start_at')->default('2020-01-01');
            $table->date('end_at')->default('2080-01-01');
            $table->longText('campaign')->nullable();
            $table->boolean('featured')->default(0);
            $table->boolean('mobile_show')->default(1);
            $table->unsignedBigInteger('offer_category_id')->nullable();
            $table->integer('mobile_category_id')->nullable();
            $table->string('header_image')->nullable();
            $table->text('facebook_title')->nullable();
            $table->mediumText('facebook_description')->nullable();
            $table->string('facebook_image', 255)->nullable();
            $table->text('twitter_title')->nullable();
            $table->mediumText('twitter_description')->nullable();
            $table->string('twitter_image', 255)->nullable();
            $table->text('meta_title')->nullable();
            $table->uuid('bu_id')->nullable();
            
            $table->foreign('offer_category_id', 'offers_offer_category_id_foreign')->references('id')->on('offer_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offers');
    }
}
