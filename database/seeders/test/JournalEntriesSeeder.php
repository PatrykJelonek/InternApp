<?php

namespace Database\Seeders\Test;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JournalEntriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('journal_entries')->insert(
            [
                [
                    'internship_id' => 1,
                    'content' => 'Pierwszy wpis',
                    'user_id' => 2,
                    'accepted' => true,
                    'created_at' => Carbon::today()->addDays(16),
                    'updated_at' => Carbon::today()->addDays(16),
                ],
                [
                    'internship_id' => 1,
                    'content' => 'Drugi wpis',
                    'user_id' => 2,
                    'accepted' => false,
                    'created_at' => Carbon::today()->addDays(17),
                    'updated_at' => Carbon::today()->addDays(17),
                ],
                [
                    'internship_id' => 1,
                    'content' => 'Trzeci wpis',
                    'user_id' => 2,
                    'accepted' => false,
                    'created_at' => Carbon::today()->addDays(20),
                    'updated_at' => Carbon::today()->addDays(20),
                ],
            ]
        );
    }
}
