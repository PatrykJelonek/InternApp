<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('offer_id')->nullable();
            $table->foreign('offer_id')->references('id')->on('agreements');
            $table->foreignId('agreement_id')->nullable();
            $table->foreign('agreement_id')->references('id')->on('agreements');
//            $table->foreignId('student_id');
//            $table->foreign('student_id')->references('id')->on('students');
            $table->foreignId('company_supervisor_id')->nullable();
            $table->foreign('company_supervisor_id')->references('id')->on('users');
            $table->foreignId('university_supervisor_id');
            $table->foreign('university_supervisor_id')->references('id')->on('users');
            //$table->integer('grade')->nullable();
            $table->dateTime('interview_date')->nullable();
            $table->foreignId('internship_status_id');
            $table->foreign('internship_status_id')->references('id')->on('internship_statuses');
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
        Schema::dropIfExists('internships');
    }
}
