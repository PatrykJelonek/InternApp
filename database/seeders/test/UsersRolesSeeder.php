<?php

namespace Database\Seeders\Test;

use config\constants\RoleConstants;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users_roles')->insert([
            'user_id' => 2,
            'role_id' => 2,
            'user_type' => RoleConstants::BASIC_ROLE_USER_TYPES[RoleConstants::ROLE_STUDENT],
            'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('users_roles')->insert([
            'user_id' => 3,
            'role_id' => 3,
            'user_type' => RoleConstants::BASIC_ROLE_USER_TYPES[RoleConstants::ROLE_UNIVERSITY_WORKER],
            'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('users_roles')->insert([
            'user_id' => 4,
            'role_id' => 4,
            'user_type' => RoleConstants::BASIC_ROLE_USER_TYPES[RoleConstants::ROLE_UNIVERSITY_OWNER],
            'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('users_roles')->insert([
            'user_id' => 5,
            'role_id' => 5,
            'user_type' => RoleConstants::BASIC_ROLE_USER_TYPES[RoleConstants::ROLE_DEANERY_WORKER],
            'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('users_roles')->insert([
            'user_id' => 6,
            'role_id' => 6,
            'user_type' => RoleConstants::BASIC_ROLE_USER_TYPES[RoleConstants::ROLE_COMPANY_WORKER],
            'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('users_roles')->insert([
            'user_id' => 7,
            'role_id' => 7,
            'user_type' => RoleConstants::BASIC_ROLE_USER_TYPES[RoleConstants::ROLE_COMPANY_OWNER],
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
}
