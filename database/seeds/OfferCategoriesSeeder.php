<?php

use Illuminate\Database\Seeder;

class OfferCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('offer_categories')->insert([
            'name' => 'Programowanie',
            'description' => 'oferta dla programistów',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('offer_categories')->insert([
            'name' => 'Grafika',
            'description' => 'oferta dla grafików',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('offer_categories')->insert([
            'name' => 'Sieci',
            'description' => 'oferta dla sieciowców',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}
