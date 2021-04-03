<?php

namespace Database\Seeders;

use App\Models\OfferStatus;
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
        foreach (OfferStatus::STATUSES as $STATUS) {
            DB::table('offer_statuses')->insert([
                'name' => $STATUS,
                'description' => OfferStatus::STATUS_DESCRIPTIONS[$STATUS],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
    }
}
