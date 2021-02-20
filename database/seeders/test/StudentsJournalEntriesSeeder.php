<?php

namespace Database\Seeders\Test;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentsJournalEntriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('students_journal_entries')->insert(
            [
                [
                    'student_id' => 1,
                    'journal_entry' => 1,
                ],
                [
                    'student_id' => 1,
                    'journal_entry' => 2,
                ],
            ]
        );
    }
}
