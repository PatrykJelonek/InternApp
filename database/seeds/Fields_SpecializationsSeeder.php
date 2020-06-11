<?php

use Illuminate\Database\Seeder;

class Fields_SpecializationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('fields_specializations')->insert([
            'field_id' => 1,
            'specialization_id' => 1,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('fields_specializations')->insert([
            'field_id' => 1,
            'specialization_id' => 2,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('fields_specializations')->insert([
            'field_id' => 2,
            'specialization_id' => 3,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
}
