<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelatedOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('related_offers', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('post_id');
            $table->unsignedInteger('offer_id');
            $table->timestamps();

            $table->foreign('offer_id', 'related_offers_offer_id_foreign')->references('id')->on('offers')->onDelete('no action');
            $table->foreign('post_id', 'related_offers_post_id_foreign')->references('id')->on('posts')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('related_offers');
    }
}
