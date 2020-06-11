<?php

use Illuminate\Database\Seeder;

class Permissions_RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions_roles')->insert([
        	'permission_id' => 1,
        	'role_id' => 1,
            'created_at' => date('Y-m-d H:i:s')           
        ]);

        DB::table('permissions_roles')->insert([
        	'permission_id' => 2,
        	'role_id' => 2,
            'created_at' => date('Y-m-d H:i:s')           
        ]);     

        DB::table('permissions_roles')->insert([
        	'permission_id' => 3,
        	'role_id' => 3,
            'created_at' => date('Y-m-d H:i:s')           
        ]);           

        DB::table('permissions_roles')->insert([
        	'permission_id' => 4,
        	'role_id' => 4,
            'created_at' => date('Y-m-d H:i:s')           
        ]);   

        DB::table('permissions_roles')->insert([
        	'permission_id' => 4,
        	'role_id' => 5,
            'created_at' => date('Y-m-d H:i:s')           
        ]);    

        DB::table('permissions_roles')->insert([
        	'permission_id' => 5,
        	'role_id' => 6,
            'created_at' => date('Y-m-d H:i:s')           
        ]);  

        DB::table('permissions_roles')->insert([
        	'permission_id' => 5,
        	'role_id' => 7,
            'created_at' => date('Y-m-d H:i:s')           
        ]);                              
    }
}

