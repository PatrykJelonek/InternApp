<?php

namespace Database\Seeders\Test;

use Config\Constants\InternshipConstants;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FieldsSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        foreach (InternshipConstants::INTERNSHIP_STATUSES as $STATUS) {
            DB::table('fields')->insert([
                'name' => $STATUS,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
    }
}
