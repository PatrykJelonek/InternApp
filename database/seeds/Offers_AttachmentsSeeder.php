<?php

use Illuminate\Database\Seeder;

class Offers_AttachmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	
    	DB::table('offers_attachments')->insert([
        	'offer_id' => 1,
        	'attachment_id' => 1
        ]);

    	DB::table('offers_attachments')->insert([
        	'offer_id' => 2,
        	'attachment_id' => 1
        ]);


    	DB::table('offers_attachments')->insert([
        	'offer_id' => 3,
        	'attachment_id' => 1
        ]);
    }
}