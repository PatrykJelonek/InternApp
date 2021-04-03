<?php

namespace Database\Seeders\Test;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersUniversitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users_universities')->insert(
            [
                [
                    'user_id' => 2,
                    'university_id' => 1,
                    'created_at' => now(),
                ],
                [
                    'user_id' => 3,
                    'university_id' => 1,
                    'created_at' => now(),
                ],
                [
                    'user_id' => 4,
                    'university_id' => 1,
                    'created_at' => now(),
                ],
                [
                    'user_id' => 5,
                    'university_id' => 1,
                    'created_at' => now(),
                ],
                [
                    'user_id' => 8,
                    'university_id' => 1,
                    'created_at' => now(),
                ]
            ]
        );
    }
}
