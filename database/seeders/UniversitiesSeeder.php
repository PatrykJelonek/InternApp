<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UniversitiesSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table('universities')->insert([
            'name' => 'Państwowa Wyższa Szkoła Państwowa',
            'university_type_id' => 2,
            'city_id' => 5,
            'street' => 'Wojska Polskiego',
            'street_number' => '1',
            'email' => 'kontakt@pwsz.elblag.pl',
            'phone' => '545545545',
            'website' => 'pwsz.elblag.pl',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('universities')->insert([
            'name' => 'Politechnika Gdańska',
            'university_type_id' => 2,
            'city_id' => 1,
            'street' => 'Gabriela Narutowicza',
            'street_number' => '11/12',
            'email' => 'kontakt@pg.edu.pl',
            'phone' => '583471100',
            'website' => 'pg.edu.pl',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}
