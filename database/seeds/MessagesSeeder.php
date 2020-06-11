<?php

use Illuminate\Database\Seeder;

class MessagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('messages')->insert([
            'content' => 'Cześć Patryk',
            'from_user_id' => 1,
            'to_user_id' => 2,
            'created_at' => date('Y-m-d H:i:s')
        ]);


        DB::table('messages')->insert([
            'content' => 'Cześć Wojtek',
            'from_user_id' => 1,
            'to_user_id' => 3,
            'created_at' => date('Y-m-d H:i:s')
        ]);


        DB::table('messages')->insert([
            'content' => 'Cześć Marcin',
            'from_user_id' => 2,
            'to_user_id' => 1,
            'created_at' => date('Y-m-d H:i:s')
        ]);


        DB::table('messages')->insert([
            'content' => 'Cześć Marcin',
            'from_user_id' => 3,
            'to_user_id' => 1,
            'created_at' => date('Y-m-d H:i:s')
        ]);


        DB::table('messages')->insert([
            'content' => 'Szanowny Panie Dyrektorze, proszę o zaliczenie praktyki bez konieczności jej odbywania. Z poważaniem student Marcin',
            'from_user_id' => 1,
            'to_user_id' => 4,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
}