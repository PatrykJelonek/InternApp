<?php

namespace Database\Seeders\Test;

use App\Constants\RoleConstants;
use App\Models\Role;
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
            'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('users_roles')->insert([
            'user_id' => 3,
            'role_id' => 3,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('users_roles')->insert([
            'user_id' => 3,
            'role_id' => 10,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('users_roles')->insert([
            'user_id' => 4,
            'role_id' => 4,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('users_roles')->insert([
            'user_id' => 5,
            'role_id' => 5,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('users_roles')->insert([
            'user_id' => 6,
            'role_id' => 6,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('users_roles')->insert([
            'user_id' => 6,
            'role_id' => 11,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('users_roles')->insert([
            'user_id' => 7,
            'role_id' => 7,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('users_roles')->insert([
            'user_id' => 8,
            'role_id' => 2,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('users_roles')->insert([
            'user_id' => 9,
            'role_id' => 3,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('users_roles')->insert([
            'user_id' => 9,
            'role_id' => 10,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
}
