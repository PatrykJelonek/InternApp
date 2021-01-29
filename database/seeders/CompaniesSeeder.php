<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompaniesSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {

        DB::table('companies')->insert([
        	'name' => 'OPGK',
        	'city_id' => 4,
            'street' => 'Grunwaldzka',
            'street_number' => '7a',
			'email' => 'opgk@mail.mail',
			'phone' => '123123123',
			'website' => 'www.opgk.opgk.pl',
			'description' => 'Firma znajdująca się w Elblągu',
			'access_code' => '82-300',
			'company_category_id' => 1,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('companies')->insert([
        	'name' => 'Comarch',
        	'city_id' => 1,
            'street' => 'Wielka',
            'street_number' => '23',
			'email' => 'comarch@mail.mail',
			'phone' => '678678678',
			'website' => 'www.comarch.pl',
			'description' => 'Firma zastępująca profesjonalistów studentami',
			'access_code' => '70-300',
			'company_category_id' => 2,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s')
        ]);


        DB::table('companies')->insert([
        	'name' => 'Lufthansa',
        	'city_id' => 2,
            'street' => 'Lotnicza',
            'street_number' => '7a',
			'email' => 'lufthansa@mail.mail',
			'phone' => '789789789',
			'website' => 'www.lufthansa.lufthansa.pl',
			'description' => 'Firma z branży lotniczej',
			'access_code' => '00-300',
			'company_category_id' => 3,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s')
        ]);

    }
}
