<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Company_CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table('company_categories')->insert([
        	'name' => 'Oprogramowanie',
        	'description' => 'Rozwój oprogramowania',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('company_categories')->insert([
        	'name' => 'Elektronika',
        	'description' => 'Elektronika i telekomunikacja',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);


        DB::table('company_categories')->insert([
        	'name' => 'Sieci',
        	'description' => 'Sieci komputerowe',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);


        DB::table('company_categories')->insert([
        	'name' => 'Grafika',
        	'description' => 'Grafika komputerowa',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);


        DB::table('company_categories')->insert([
        	'name' => 'Gry',
        	'description' => 'Gry komputerowe',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}
