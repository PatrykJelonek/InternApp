<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('offer_id');
            $table->foreign('offer_id')->references('id')->on('offers');
            $table->foreignId('attachment_id');
            $table->foreign('attachment_id')->references('id')->on('attachments');
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
        Schema::dropIfExists('offers_attachments');
    }
}
