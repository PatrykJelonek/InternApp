<?php

use Illuminate\Database\Seeder;

class AttachmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         
        DB::table('attachments')->insert([
            'name' => 'Porozumienie między uczelnią a zakładem pracy.',
            'description' => 'Ustalenie warunków odbywania praktyki.',
            'type' => 'dokument',
            'user_id' => 4,//dyrektor instytutu
            'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('attachments')->insert([
            'name' => 'Ubezpieczenie NNW i OC.',
            'description' => 'Ubezpieczenie NNW i OC.',
            'type' => 'dokument',
            'user_id' => 5,//pracownik dziekanatu
            'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('attachments')->insert([
            'name' => 'Skierowanie studenta na praktykę.',
            'description' => 'Skierowanie studenta na praktykę.',
            'type' => 'dokument',
            'user_id' => 4,//pracownik dziekanatu
            'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('attachments')->insert([
            'name' => 'Umowa dwustronna.',
            'description' => 'Umowa dwustronna.',
            'type' => 'dokument',
            'user_id' => 4,//dyrektor instytutu
            'created_at' => date('Y-m-d H:i:s')
        ]);

            DB::table('attachments')->insert([
            'name' => 'Umowa trójstronna.',
            'description' => 'Umowa trójstronna.',
            'type' => 'dokument',
            'user_id' => 4,//dyrektor instytutu
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
}
