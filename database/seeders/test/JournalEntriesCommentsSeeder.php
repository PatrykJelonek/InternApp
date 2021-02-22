<?php

namespace Database\Seeders\Test;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JournalEntriesCommentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('journal_entries_comments')->insert([
            [
                'journal_entry_id' => 1,
                'comment_id' => 1,
            ],
        ]);
    }
}
