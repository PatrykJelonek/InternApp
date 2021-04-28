<?php

namespace Database\Seeders;

use App\Constants\OfferCategoryConstants;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OfferCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        foreach (OfferCategoryConstants::BASIC_CATEGORIES as $CATEGORY) {
            DB::table('offer_categories')->insert([
                'name' => $CATEGORY,
                'description' => OfferCategoryConstants::BASIC_CATEGORY_DESCRIPTIONS[$CATEGORY],
                'display_name' => OfferCategoryConstants::BASIC_CATEGORY_DISPLAY_NAMES[$CATEGORY],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
    }
}
