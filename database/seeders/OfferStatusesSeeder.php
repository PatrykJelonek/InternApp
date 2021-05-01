<?php

namespace Database\Seeders;

use App\Constants\OfferStatusConstants;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OfferStatusesSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        foreach (OfferStatusConstants::STATUSES as $STATUS) {
            DB::table('offer_statuses')->insert([
                'name' => $STATUS,
                'description' => OfferStatusConstants::STATUS_DESCRIPTIONS[$STATUS],
                'display_name' => OfferStatusConstants::STATUS_DISPLAY_NAMES[$STATUS],
                'hex_color' => OfferStatusConstants::STATUS_HEX_COLORS[$STATUS],
                'group' => OfferStatusConstants::STATUS_GROUP[$STATUS],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
    }
}
