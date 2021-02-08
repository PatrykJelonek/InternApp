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
        DB::table('offer_statuses')->insert([
            'name' => OfferStatus::STATUS_NEW,
            'description' => 'Nowa',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('offer_statuses')->insert([
            'name' => OfferStatus::STATUS_ACCEPTED,
            'description' => 'Zaakceptowana',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('offer_statuses')->insert([
            'name' => OfferStatus::STATUS_REJECTED,
            'description' => 'Odrzucona',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}
