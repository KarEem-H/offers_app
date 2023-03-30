<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers_relations', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('offer_id');
            $table->unsignedInteger('clinic_id')->nullable();
            $table->unsignedInteger('service_id')->nullable();
            $table->unsignedInteger('doctor_id')->nullable();

            $table->foreign('clinic_id', 'offers_relations_clinic_id_foreign')->references('id')->on('clinics')->onDelete('no action');
            $table->foreign('doctor_id', 'offers_relations_doctor_id_foreign')->references('id')->on('doctors')->onDelete('no action');
            $table->foreign('offer_id', 'offers_relations_offer_id_foreign')->references('id')->on('offers')->onDelete('no action');
            $table->foreign('service_id', 'offers_relations_service_id_foreign')->references('id')->on('services')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offers_relations');
    }
}
