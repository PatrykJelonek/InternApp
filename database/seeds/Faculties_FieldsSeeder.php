<?php

use Illuminate\Database\Seeder;

class Faculties_FieldsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('faculties_fields')->insert([
            'faculty_id' => 1,
            'field_id' => 1,
            'created_at' => date('Y-m-d H:i:s')
        ]);
        
        DB::table('faculties_fields')->insert([
            'faculty_id' => 1,
            'field_id' => 2,
            'created_at' => date('Y-m-d H:i:s')
        ]);       
    }
}
