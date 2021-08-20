<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJournalEntriesCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students_journal_entries_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_journal_entry_id');
            $table->foreign('student_journal_entry_id','journal_entry_comment_foreign')->references('id')->on('students_journal_entries');
            $table->foreignId('comment_id');
            $table->foreign('comment_id')->references('id')->on('comments');
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
        Schema::dropIfExists('students_journal_entries_comments');
        Schema::dropIfExists('journal_entries_comments');
    }
}
