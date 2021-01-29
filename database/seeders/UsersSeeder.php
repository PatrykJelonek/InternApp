<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        //Example admin
        DB::table('users')->insert(
            [
                'email' => 'admin@example.com',
                'password_hash' => Hash::make('password'),
                'password_reset_token' => 'token',
                'first_name' => 'Jan',
                'last_name' => 'Kowalski',
                'phone_number' => '123123123',
                'user_status_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        );

        //Example student
        DB::table('users')->insert(
            [
                'email' => 'student@example.com',
                'password_hash' => Hash::make('password'),
                'password_reset_token' => 'token',
                'first_name' => 'Adam',
                'last_name' => 'Mickiewicz',
                'phone_number' => '123123123',
                'user_status_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        );

        //Example dziekanat
        DB::table('users')->insert(
            [
                'email' => 'dziekanat@example.com',
                'password_hash' => Hash::make('password'),
                'password_reset_token' => 'token',
                'first_name' => 'Piotr',
                'last_name' => 'Nowak',
                'phone_number' => '123123123',
                'user_status_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        );

        //Example pracownik firmy
        DB::table('users')->insert(
            [
                'email' => 'firma@example.com',
                'password_hash' => Hash::make('password'),
                'password_reset_token' => 'token',
                'first_name' => 'Barbara',
                'last_name' => 'Pawlak',
                'phone_number' => '123123123',
                'user_status_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        );
    }
}
