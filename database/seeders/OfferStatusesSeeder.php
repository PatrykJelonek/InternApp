<?php

namespace Database\Seeders;

use Config\Constants\OfferConstants;
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
        foreach (OfferConstants::OFFER_STATUSES as $STATUS) {
            DB::table('offer_statuses')->insert([
                'name' => $STATUS,
                'description' => OfferConstants::OFFER_STATUS_DESCRIPTIONS[$STATUS],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
    }
}
