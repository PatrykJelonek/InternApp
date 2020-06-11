<?php

use Illuminate\Database\Seeder;

class Agreements_AttachmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('agreements_attachments')->insert([
        	'agreement_id' => 1,
        	'attachment_id' => 5,
        ]);

        DB::table('agreements_attachments')->insert([
        	'agreement_id' => 2,
        	'attachment_id' => 5,
        ]);
    }
}
