<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class Internship_StatusesSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        //1
        DB::table('internship_statuses')->insert([
            'name' => 'new',
            'created_at' => date('Y-m-d H:i:s')
        ]);

        //2
        DB::table('internship_statuses')->insert([
            'name' => 'accepted',
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
}
