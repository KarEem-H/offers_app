<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersLeadsViewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers_leads_view', function (Blueprint $table) {
            $table->unsignedInteger('id')->nullable();
            $table->string('name', 255)->nullable();
            $table->string('phone', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->longText('offer')->nullable();
            $table->string('business_unit', 3)->nullable();
            $table->string('branch', 255)->nullable();
            $table->string('payment', 255)->nullable();
            $table->timestamp('reservetion_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('transaction_date')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offers_leads_view');
    }
}
