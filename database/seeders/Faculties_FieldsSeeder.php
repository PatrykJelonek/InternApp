<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Faculties_FieldsSeeder extends Seeder
{
    /**
     * Run the database seeders.
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
