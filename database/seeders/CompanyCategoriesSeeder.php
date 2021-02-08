<?php

namespace Database\Seeders;

use App\Models\CompanyCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanyCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table('company_categories')->insert([
        	'name' => CompanyCategory::CATEGORY_SOFTWARE,
        	'description' => 'Rozwój oprogramowania',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('company_categories')->insert([
        	'name' => CompanyCategory::CATEGORY_ELECTRONICS,
        	'description' => 'Elektronika i telekomunikacja',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);


        DB::table('company_categories')->insert([
        	'name' => CompanyCategory::CATEGORY_COMPUTER_NETWORKS,
        	'description' => 'Sieci komputerowe',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);


        DB::table('company_categories')->insert([
        	'name' => CompanyCategory::CATEGORY_GRAPHICS,
        	'description' => 'Grafika komputerowa',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);


        DB::table('company_categories')->insert([
        	'name' => CompanyCategory::CATEGORY_GAMES,
        	'description' => 'Gry komputerowe',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}
