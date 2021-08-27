<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUniversitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('universities', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->unique();
            $table->foreignId('university_type_id');
            $table->foreign('university_type_id')->references('id')->on('university_types');
            $table->foreignId('city_id');
            $table->foreign('city_id')->references('id')->on('cities');
            $table->string('street',64);
            $table->string('street_number', 8);
            $table->string('email',64)->unique();
            $table->string('phone', 16);
            $table->string('website', 64)->nullable();
            $table->string('access_code', 8)->nullable()->unique();
            $table->string('slug', 255)->unique();
            $table->string('logo_url', 255)->nullable();
            $table->boolean('verified')->default(false);
            $table->foreignId('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('universities');
    }
}
