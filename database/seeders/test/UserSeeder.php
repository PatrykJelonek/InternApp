<?php

namespace Database\Seeders\Test;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'email' => 'student@example.com',
            'password_hash' => Hash::make('password'),
            'password_reset_token' => Hash::make(Str::random(32)),
            'first_name' => 'Adam',
            'last_name' => 'Nowacki',
            'phone' => '345123986',
            'user_status_id' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('users')->insert([
            'email' => 'university_worker@example.com',
            'password_hash' => Hash::make('password'),
            'password_reset_token' => Hash::make(Str::random(32)),
            'first_name' => 'Piotr',
            'last_name' => 'Maciejewski',
            'phone' => '765342043',
            'user_status_id' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('users')->insert([
            'email' => 'university_owner@example.com',
            'password_hash' => Hash::make('password'),
            'password_reset_token' => Hash::make(Str::random(32)),
            'first_name' => 'Magdalena',
            'last_name' => 'Wiśniewska',
            'phone' => '873456123',
            'user_status_id' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('users')->insert([
            'email' => 'deanery_worker@example.com',
            'password_hash' => Hash::make('password'),
            'password_reset_token' => Hash::make(Str::random(32)),
            'first_name' => 'Marta',
            'last_name' => 'Piotrowska',
            'phone' => '873456123',
            'user_status_id' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('users')->insert([
            'email' => 'company_worker@example.com',
            'password_hash' => Hash::make('password'),
            'password_reset_token' => Hash::make(Str::random(32)),
            'first_name' => 'Adam',
            'last_name' => 'Janusz',
            'phone' => '876234093',
            'user_status_id' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('users')->insert([
            'email' => 'company_owner@example.com',
            'password_hash' => Hash::make('password'),
            'password_reset_token' => Hash::make(Str::random(32)),
            'first_name' => 'Mateusz',
            'last_name' => 'Trombka',
            'phone' => '734956023',
            'user_status_id' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('users')->insert([
            'email' => 'student2@example.com',
            'password_hash' => Hash::make('password'),
            'password_reset_token' => Hash::make(Str::random(32)),
            'first_name' => 'Małgorzata',
            'last_name' => 'Maczek',
            'phone' => '345132412',
            'user_status_id' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}
