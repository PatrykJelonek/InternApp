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
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
    }
}
