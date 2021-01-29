<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TasksSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
		DB::table('tasks')->insert([
            'name' => 'Przygotowanie',
            'description' => 'Przygotowanie stanowiska pracy.',
            'internship_id' => 1,
            'user_id' => 1,
			'done' => true,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s')
        ]);

		DB::table('tasks')->insert([
            'name' => 'Przygotowanie',
            'description' => 'Przygotowanie stanowiska pracy.',
            'internship_id' => 2,
            'user_id' => 2,
			'done' => true,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s')
        ]);

		DB::table('tasks')->insert([
            'name' => 'Przygotowanie',
            'description' => 'Przygotowanie stanowiska pracy.',
            'internship_id' => 3,
            'user_id' => 3,
			'done' => true,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s')
        ]);

		DB::table('tasks')->insert([
            'name' => 'Wprowadzenie',
            'description' => 'Napisanie prostego programu.',
            'internship_id' => 1,
            'user_id' => 1,
			'done' => true,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s')
        ]);

		DB::table('tasks')->insert([
            'name' => 'Wprowadzenie',
            'description' => 'Napisanie prostego programu.',
            'internship_id' => 2,
            'user_id' => 2,
			'done' => true,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s')
        ]);

		DB::table('tasks')->insert([
            'name' => 'Przygotowanie',
            'description' => 'Podłączenie komputera do sieci.',
            'internship_id' => 3,
            'user_id' => 3,
			'done' => true,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}
