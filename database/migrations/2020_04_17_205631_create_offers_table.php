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
            $table->id();
            $table->foreignId('company_id');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreignId('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('name', 80)->unique();
            $table->integer('places_number')->nullable()->default(0);
            $table->longText('program')->nullable();
            $table->longText('schedule')->nullable();
            $table->foreignId('offer_category_id');
            $table->foreign('offer_category_id')->references('id')->on('offer_categories');
            $table->foreignId('offer_status_id');
            $table->foreign('offer_status_id')->references('id')->on('offer_statuses');
            $table->foreignId('company_supervisor_id')->nullable();
            $table->foreign('company_supervisor_id')->references('id')->on('users');
            $table->date('date_from')->nullable();
            $table->date('date_to')->nullable();
            $table->string('slug', 80)->unique();
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
        Schema::dropIfExists('agreements');
        Schema::dropIfExists('offers');
    }
}
