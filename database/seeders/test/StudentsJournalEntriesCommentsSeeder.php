<?php

namespace Database\Seeders\Test;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentsJournalEntriesCommentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('students_journal_entries_comments')->insert([
            [
                'student_journal_entry_id' => 1,
                'comment_id' => 1,
            ],
        ]);
    }
}
