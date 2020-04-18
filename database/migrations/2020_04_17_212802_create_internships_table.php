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
            $table->foreign('offer_id')->references('id')->on('offers');
            $table->foreign('student_id')->references('id')->on('students');
            $table->foreign('company_supervisor_id')->references('id')->on('users');
            $table->foreign('university_supervisor_id')->references('id')->on('users');
            $table->integer('grade');
            $table->dateTime('interview_date');
            $table->foreign('internships_status_id')->references('id')->on('internship_statuses');
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
        Schema::dropIfExists('internships');
    }
}
