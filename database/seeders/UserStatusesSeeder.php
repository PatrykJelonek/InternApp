<?php

namespace Database\Seeders;

use Config\Constants\UserConstants;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserStatusesSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        foreach (UserConstants::USER_STATUSES as $STATUS) {
            DB::table('user_statuses')->insert([
                'name' => $STATUS,
                'description' => UserConstants::USER_STATUS_DESCRIPTIONS[$STATUS],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
    }
}
