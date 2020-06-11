<?php

use Illuminate\Database\Seeder;

class Users_PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

		DB::table('users_permissions')->insert([
        	'user_id' => 1,
        	'permission_id' => 3,
            'user_type' => 'Student',//Student - uprawnienia studenta
            'created_at' => date('Y-m-d H:i:s')
        ]);        


		DB::table('users_permissions')->insert([
        	'user_id' => 2,
        	'permission_id' => 3,           
            'user_type' => 'Student',//Student - uprawnienia studenta
            'created_at' => date('Y-m-d H:i:s')
        ]);        


		DB::table('users_permissions')->insert([
        	'user_id' => 3,
        	'permission_id' => 3,           
            'user_type' => 'Student',//Student - uprawnienia studenta
            'created_at' => date('Y-m-d H:i:s')
        ]);        


		DB::table('users_permissions')->insert([
        	'user_id' => 4,
        	'permission_id' => 5,            
            'user_type' => 'Dyrektor',//Dyrektor - uprawnienia uczelni
            'created_at' => date('Y-m-d H:i:s')
        ]);        


		DB::table('users_permissions')->insert([
        	'user_id' => 5,
        	'permission_id' => 3,            
            'user_type' => 'Pracownicy dziekanatu',//Pracownicy dziekanatu - uprawnienia uczelni
            'created_at' => date('Y-m-d H:i:s')
        ]);        


		DB::table('users_permissions')->insert([
        	'user_id' => 6,
        	'permission_id' => 3,            
            'user_type' => 'Opiekun zakładowy',//Opiekun zakładowy - uprawnienia zakładu pracy
            'created_at' => date('Y-m-d H:i:s')
        ]);        


		DB::table('users_permissions')->insert([
        	'user_id' => 7,
        	'permission_id' => 3,            
            'user_type' => 'Koordynator zakładowy',//Koordynator zakładowy - uprawnienia zakładu pracy
            'created_at' => date('Y-m-d H:i:s')
        ]);        


		DB::table('users_permissions')->insert([
        	'user_id' => 8,
        	'permission_id' => 1,            
            'user_type' => 'Superadministrator',//Superadmin - uprawnienia superadministratora
            'created_at' => date('Y-m-d H:i:s')
        ]);        


		DB::table('users_permissions')->insert([
        	'user_id' => 9,
        	'permission_id' => 4,            
            'user_type' => 'Opiekun zakładowy',//Opiekun zakładowy - uprawnienia zakładu pracy
            'created_at' => date('Y-m-d H:i:s')
        ]);   


		DB::table('users_permissions')->insert([
        	'user_id' => 10,
        	'permission_id' => 4,            
            'user_type' => 'Koordynator zakładowy',//Koordynator zakładowy - uprawnienia zakładu pracy
            'created_at' => date('Y-m-d H:i:s')
        ]);        

        DB::table('users_permissions')->insert([
            'user_id' => 11,
            'permission_id' => 3,
            'user_type' => 'Student',//Student - uprawnienia studenta
            'created_at' => date('Y-m-d H:i:s')
        ]);   

        DB::table('users_permissions')->insert([
            'user_id' => 12,
            'permission_id' => 3,
            'user_type' => 'Student',//Student - uprawnienia studenta
            'created_at' => date('Y-m-d H:i:s')
        ]);   
    }
}