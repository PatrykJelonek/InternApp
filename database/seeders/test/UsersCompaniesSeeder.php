<?php

namespace Database\Seeders\Test;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersCompaniesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users_companies')->insert(
            [
                [
                    'user_id' => 6,
                    'company_id' => 1,
                    'created_at' => now(),
                ],
                [
                    'user_id' => 7,
                    'company_id' => 1,
                    'created_at' => now(),
                ],
            ]
        );
    }
}
