<?php

namespace Database\Seeders\Test;

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
        DB::table('companies')->insert(
            [
                [
                    'name' => 'Polcom Software',
                    'city_id' => 1,
                    'street' => 'Wąska',
                    'street_number' => '13/2 A',
                    'email' => 'polcom@example.com',
                    'phone' => '435024012',
                    'website' => 'http://polcomsoftware.com',
                    'description' => 'Od dziesięciu lat dostarczamy naszym klientom najwyższej jakości oprogramowanie.',
                    'access_code' => '23AC2x2M',
                    'company_category_id' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]
        );
    }
}
