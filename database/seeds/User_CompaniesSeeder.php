<?php

use Illuminate\Database\Seeder;

class User_CompaniesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('user_companies')->insert([
            'user_id' => 6,
            'company_id' => 1,
            'created_at' => date('Y-m-d H:i:s'),            
        ]);


        DB::table('user_companies')->insert([
            'user_id' => 7,
            'company_id' => 1,
            'created_at' => date('Y-m-d H:i:s'),            
        ]);


        DB::table('user_companies')->insert([
            'user_id' => 9,
            'company_id' => 2,
            'created_at' => date('Y-m-d H:i:s'),            
        ]);


        DB::table('user_companies')->insert([
            'user_id' => 10,
            'company_id' => 3,
            'created_at' => date('Y-m-d H:i:s'),            
        ]);
    }
}