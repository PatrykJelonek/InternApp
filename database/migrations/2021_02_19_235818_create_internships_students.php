<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternshipsStudents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internships_students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('internship_id');
            $table->foreign('internship_id')->references('id')->on('internships');
            $table->foreignId('student_id');
            $table->foreign('student_id')->references('id')->on('students');
            $table->integer('grade')->nullable();
            $table->date('interview_date');
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
        Schema::dropIfExists('internships_students');
    }
}
