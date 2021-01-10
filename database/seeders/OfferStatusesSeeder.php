<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

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
            'name' => 'new',
            'description' => 'nowa',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('offer_statuses')->insert([
            'name' => 'accepted',
            'description' => 'zaakceptowana',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('offer_statuses')->insert([
            'name' => 'rejected',
            'description' => 'odrzucona',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}
