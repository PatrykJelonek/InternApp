<?php

use Illuminate\Database\Seeder;

class Users_RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users_roles')->insert([
        	'user_id' => 1,
        	'role_id' => 3,
            'user_type' => 'User type: student',
            'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('users_roles')->insert([
        	'user_id' => 2,
        	'role_id' => 3,
            'user_type' => 'User type: student',
            'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('users_roles')->insert([
        	'user_id' => 3,
        	'role_id' => 3,
            'user_type' => 'User type: student',
            'created_at' => date('Y-m-d H:i:s')
        ]);


        DB::table('users_roles')->insert([
        	'user_id' => 8,
        	'role_id' => 1,
            'user_type' => 'User type: superadmin',
            'created_at' => date('Y-m-d H:i:s')
        ]);



        DB::table('users_roles')->insert([
        	'user_id' => 9,
        	'role_id' => 4,
            'user_type' => 'User type: opiekun zakładowy',
            'created_at' => date('Y-m-d H:i:s')
        ]);



        DB::table('users_roles')->insert([
        	'user_id' => 10,
        	'role_id' => 5,
            'user_type' => 'User type: superadmin',
            'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('users_roles')->insert([
            'user_id' => 11,
            'role_id' => 3,
            'user_type' => 'User type: student',
            'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('users_roles')->insert([
            'user_id' => 12,
            'role_id' => 3,
            'user_type' => 'User type: student',
            'created_at' => date('Y-m-d H:i:s')
        ]);
    
    
    }
}
