<?php

namespace Database\Seeders;

use Config\Constants\CompanyConstants;
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
        foreach(CompanyConstants::COMPANY_BASIC_CATEGORIES as $CATEGORY) {
            DB::table('company_categories')->insert([
                'name' => $CATEGORY,
                'description' => CompanyConstants::COMPANY_CATEGORY_DESCRIPTIONS[$CATEGORY],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
    }
}
