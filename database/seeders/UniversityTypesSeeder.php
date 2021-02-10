<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UniversityTypesSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table('university_types')->insert([
            'name' => 'Uniwersytet',
            'description' => 'Uniwersytet',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('university_types')->insert([
            'name' => 'Wyższa Szkoła Techniczna',
            'description' => 'Wyższa szkoła techniczna',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('university_types')->insert([
            'name' => 'Wyższa Szkoła Rolnicza',
            'description' => 'Wyższa szkoła rolnicza',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('university_types')->insert([
            'name' => 'Wyższa Szkoła Ekonomiczna',
            'description' => 'Wyższa szkoła ekonomiczna',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('university_types')->insert([
            'name' => 'Wyższa Szkoła Pedagogiczna',
            'description' => 'Wyższa szkoła pedagogiczna',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('university_types')->insert([
            'name' => 'Akademia Medyczna',
            'description' => 'Akademia medyczna',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('university_types')->insert([
            'name' => 'Wyższa Szkoła Morska',
            'description' => 'Wyższa szkoła morska',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('university_types')->insert([
            'name' => 'Akademia Wychowania Fizycznego',
            'description' => 'Akademia wychowania fizycznego',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}
