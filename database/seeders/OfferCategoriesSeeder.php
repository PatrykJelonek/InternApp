<?php

namespace Database\Seeders;

use Config\Constants\OfferConstants;
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
        foreach (OfferConstants::OFFER_BASIC_CATEGORIES as $CATEGORY) {
            DB::table('offer_categories')->insert([
                'name' => $CATEGORY,
                'description' => OfferConstants::OFFER_BASIC_CATEGORY_DESCRIPTIONS[$CATEGORY],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
    }
}
