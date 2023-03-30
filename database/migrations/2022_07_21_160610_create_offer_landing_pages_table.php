<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfferLandingPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offer_landing_pages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image');
            $table->string('thumbnail');
            $table->timestamp('start_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('end_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->text('description');
            $table->decimal('price_before', 8, 2);
            $table->decimal('price_after', 8, 2);
            $table->string('slug')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('facebook_title')->nullable();
            $table->text('facebook_description')->nullable();
            $table->string('facebook_image')->nullable();
            $table->string('twitter_title')->nullable();
            $table->text('twitter_description')->nullable();
            $table->string('twitter_image')->nullable();
            $table->string('mobile_image');
            $table->text('short_description');
            $table->unsignedInteger('category_id')->nullable();
            $table->timestamps();
            $table->uuid('bu_id')->nullable();

            $table->foreign('category_id', 'offer_landing_pages_category_id_foreign')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offer_landing_pages');
    }
}
