<?php

use Illuminate\Database\Seeder;

class SpecializationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('specializations')->insert([
            'name' => 'Projektowanie Baz Danych i Oprogramowania Użytkowego',
            'description' => 'Projektowanie Baz Danych i Oprogramowania Użytkowego',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('specializations')->insert([
            'name' => 'Grafika Komputerowa',
            'description' => 'Grafika Komputerowa',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}
