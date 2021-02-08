<?php

namespace Database\Seeders;

use App\Models\OfferCategory;
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
        DB::table('offer_categories')->insert([
            'name' => OfferCategory::CATEGORY_SOFTWARE,
            'description' => 'oferta dla programistów',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('offer_categories')->insert([
            'name' => OfferCategory::CATEGORY_COMPUTER_GRAPHIC,
            'description' => 'oferta dla grafików',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('offer_categories')->insert([
            'name' => OfferCategory::CATEGORY_COMPUTER_NETWORKS,
            'description' => 'oferta dla sieciowców',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}
