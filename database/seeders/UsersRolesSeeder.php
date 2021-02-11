<?php

namespace Database\Seeders;

use config\constants\RoleConstants;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersRolesSeeder extends Seeder
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
            'user_type' => RoleConstants::BASIC_ROLE_USER_TYPES[RoleConstants::ROLE_ADMIN],
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
}
