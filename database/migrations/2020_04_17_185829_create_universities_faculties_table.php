<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUniversitiesFacultiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('universities_faculties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('university_id');
            $table->foreign('university_id')->references('id')->on('universities');
            $table->foreignId('faculty_id');
            $table->foreign('faculty_id')->references('id')->on('faculties');
            $table->dateTime('created_at', 0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('universities_faculties');
    }
}
