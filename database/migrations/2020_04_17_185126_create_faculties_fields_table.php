<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacultiesFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::create('faculties_fields', function (Blueprint $table) {
//            $table->id();
//            $table->foreignId('faculty_id');
//            $table->foreign('faculty_id')->references('id')->on('faculties');
//            $table->foreignId('field_id');
//            $table->foreign('field_id')->references('id')->on('fields');
//            $table->dateTime('created_at', 0);
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('faculties_fields');
    }
}
