<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Users_RolesSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users_roles')->insert([
        	'user_id' => 1,
        	'role_id' => 1,
            'user_type' => 'User type: admin',
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
}
