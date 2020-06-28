<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //1
        DB::table('users')->insert([
            'email' => 'admin@example.com',
            'password_hash' => 'password',
            'password_reset_token' => 'token',
            'first_name' => 'Jan',
            'last_name' => 'Kowalski',
            'phone_number' => '123123123',
            'user_status_id' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}
