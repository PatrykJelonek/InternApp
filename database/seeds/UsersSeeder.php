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
            'email' => 'marcinowy@marcinowy.marcinowy',
            'password_hash' => 'haslo',
            'password_reset_token' => 'token',
            'first_name' => 'Marcin',
            'last_name' => 'Marcinowy',
            'phone_number' => '123123123',
            'user_status_id' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        //2
        DB::table('users')->insert([
            'email' => 'wojtkowy@wojtkowy.wojtkowy',
            'password_hash' => 'haslo',
            'password_reset_token' => 'token',
            'first_name' => 'Wojtek',
            'last_name' => 'Wojtkowy',
            'phone_number' => '234234234',
            'user_status_id' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        //3
        DB::table('users')->insert([
            'email' => 'patrykowy@patrykowy.patrykowy',
            'password_hash' => 'haslo',
            'password_reset_token' => 'token',
            'first_name' => 'Patryk',
            'last_name' => 'Patrykowy',
            'phone_number' => '343434',
            'user_status_id' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        //4
        DB::table('users')->insert([
            'email' => 'dyrektor@dyrektor.dyrektor',
            'password_hash' => 'haslo',
            'password_reset_token' => 'token',
            'first_name' => 'Jan',
            'last_name' => 'Harnaś',
            'phone_number' => '123123123',
            'user_status_id' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        //5
        DB::table('users')->insert([
            'email' => 'ewa@sciana.granitowa',
            'password_hash' => 'haslo',
            'password_reset_token' => 'token',
            'first_name' => 'Ewa',
            'last_name' => 'Ściana',
            'phone_number' => '123123123',
            'user_status_id' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        //6
        DB::table('users')->insert([
            'email' => 'opiekun@zakladowy.zakladowy',
            'password_hash' => 'haslo',
            'password_reset_token' => 'token',
            'first_name' => 'Barbara',
            'last_name' => 'Żubr',
            'phone_number' => '123123123',
            'user_status_id' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        //7
        DB::table('users')->insert([
            'email' => 'koordynator@zakladowy.zakladowy',
            'password_hash' => 'haslo',
            'password_reset_token' => 'token',
            'first_name' => 'Adam',
            'last_name' => 'Mickiewicz',
            'phone_number' => '565656565',
            'user_status_id' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        //8
        DB::table('users')->insert([
            'email' => 'uzytkownik@uzytkownikowy.uzytkownikowy',//superadmin
            'password_hash' => 'haslo',
            'password_reset_token' => 'token',
            'first_name' => 'Krystyna',
            'last_name' => 'Czubówna',
            'phone_number' => '987898767',
            'user_status_id' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        //9
        DB::table('users')->insert([
            'email' => 'opiekun2@zakladowy.zakladowy',
            'password_hash' => 'haslo',
            'password_reset_token' => 'token',
            'first_name' => 'Stefan',
            'last_name' => 'Pogromca',
            'phone_number' => '878787877',
            'user_status_id' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        //10
        DB::table('users')->insert([
            'email' => 'koordynator2@zakladowy.zakladowy',
            'password_hash' => 'haslo',
            'password_reset_token' => 'token',
            'first_name' => 'Karolina',
            'last_name' => 'Kowlaska',
            'phone_number' => '58756665',
            'user_status_id' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        //11
        DB::table('users')->insert([
            'email' => 'student1@student1.student1',
            'password_hash' => 'haslo',
            'password_reset_token' => 'token',
            'first_name' => 'Zbigniew',
            'last_name' => 'Kwaśniewski',
            'phone_number' => '656776677',
            'user_status_id' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        //12
        DB::table('users')->insert([
            'email' => 'student2@student2.student2',
            'password_hash' => 'haslo',
            'password_reset_token' => 'token',
            'first_name' => 'Katarzyna',
            'last_name' => 'Pompon',
            'phone_number' => '333333444',
            'user_status_id' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        //13
        DB::table('users')->insert([
            'email' => 'rektorpg@rektorpg.rektorpg',
            'password_hash' => 'haslo',
            'password_reset_token' => 'token',
            'first_name' => 'Stefan',
            'last_name' => 'Rektoriusz',
            'phone_number' => '777666555',
            'user_status_id' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}