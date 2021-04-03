<?php

namespace Database\Seeders\Test;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('comments')->insert([
            [
                'content' => 'Pierwszy komentarz',
                'user_id' => 3,
            ]
        ]);
    }
}
