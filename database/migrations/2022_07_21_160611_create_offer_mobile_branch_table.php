<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfferMobileBranchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offer_mobile_branch', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mobile_branch_id')->nullable();
            $table->unsignedInteger('offer_id')->nullable();
            $table->timestamps();
            
            $table->foreign('mobile_branch_id', 'offer_mobile_branch_mobile_branch_id_foreign')->references('id')->on('mobile_branches');
            $table->foreign('offer_id', 'offer_mobile_branch_offer_id_foreign')->references('id')->on('offers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offer_mobile_branch');
    }
}
