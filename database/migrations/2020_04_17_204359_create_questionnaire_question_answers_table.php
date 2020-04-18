<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionnaireQuestionAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questionnaire_question_answers', function (Blueprint $table) {
            $table->id();
            $table->foreign('questionnaire_question_id')->references('id')->on('questionnaire_questions');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('content', 255);
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
        Schema::drop('questionnaire_question_answers');
    }
}
