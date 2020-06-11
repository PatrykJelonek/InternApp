<?php

use Illuminate\Database\Seeder;

class Users_UniversitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users_universities')->insert([
            'user_id' => 1,
            'university_id' => 1,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('users_universities')->insert([
            'user_id' => 2,
            'university_id' => 1,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('users_universities')->insert([
            'user_id' => 3,
            'university_id' => 1,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('users_universities')->insert([
            'user_id' => 11,
            'university_id' => 2,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('users_universities')->insert([
            'user_id' => 12,
            'university_id' => 2,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
