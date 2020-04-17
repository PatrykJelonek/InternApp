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
        Schema::table('offers', function (Blueprint $table) {
            $table->id();
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('name', 128);
            $table->integer('places_number')->nullable()->default(0);
            $table->longText('program')->nullable();
            $table->longText('schedule')->nullable();
            $table->foreign('offer_category_id')->references('id')->on('offer_categories');
            $table->foreign('offer_status_id')->references('id')->on('offer_statuses');
            $table->foreign('company_supervisor_id')->references('id')->on('users');
            $table->boolean('interview');
            $table->dateTime('created_at', 0);
            $table->dateTime('updated_at', 0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('offers');
    }
}
