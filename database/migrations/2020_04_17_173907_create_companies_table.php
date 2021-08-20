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
            $table->string('name', 255)->unique();
            $table->foreignId('city_id');
            $table->foreign('city_id')->references('id')->on('cities');
            $table->string('street', 128);
            $table->string('street_number', 8);
            $table->string('email', 64)->unique();
            $table->string('phone', 16)->nullable();
            $table->string('website', 64)->nullable();
            $table->string('description', 255)->nullable();
            $table->string('slug', 255)->unique();
            $table->string('access_code', 8)->nullable()->unique();
            $table->string('logo_url', 255)->nullable();
            $table->foreignId('company_category_id');
            $table->foreign('company_category_id')->references('id')->on('company_categories');
            $table->foreignId('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->boolean('accepted')->default(false);
            $table->boolean('draft')->default(false);
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
        Schema::dropIfExists('users_companies');
        Schema::dropIfExists('companies');
    }
}
