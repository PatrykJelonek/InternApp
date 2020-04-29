<?php

use Illuminate\Database\Seeder;

class UniversityTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('university_types')->insert([
            'name' => 'uniwersytet',
            'description' => 'Uniwersytet',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('university_types')->insert([
            'name' => 'wyższa szkoła techniczna',
            'description' => 'Wyższa szkoła techniczna',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('university_types')->insert([
            'name' => 'wyższa szkoła roliczna',
            'description' => 'Wyższa szkoła rolnicza',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('university_types')->insert([
            'name' => 'wyższa szkoła ekonomiczna',
            'description' => 'Wyższa szkoła ekonomiczna',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('university_types')->insert([
            'name' => 'wyższa szkoła pedagogiczna',
            'description' => 'Wyższa szkoła pedagogiczna',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('university_types')->insert([
            'name' => 'akademia medyczna',
            'description' => 'Akademia medyczna',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('university_types')->insert([
            'name' => 'wyższa szkoła morska',
            'description' => 'Wyższa szkoła morska',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('university_types')->insert([
            'name' => 'akademia wychowania fizycznego',
            'description' => 'Akademia wychowania fizycznego',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}
