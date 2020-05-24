<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name', 64)->unique();
            $table->foreignId('city_id');
            $table->foreign('city_id')->references('id')->on('cities');
            $table->string('street', 64);
            $table->string('street_number', 8);
            $table->string('email', 64)->unique();
            $table->string('phone', 16)->nullable();
            $table->string('website', 64)->nullable();
            $table->string('description', 255);
            $table->string('access_code', 8)->nullable()->unique();
            $table->foreignId('company_category_id');
            $table->foreign('company_category_id')->references('id')->on('company_categories');
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
        Schema::dropIfExists('companies');
    }
}
