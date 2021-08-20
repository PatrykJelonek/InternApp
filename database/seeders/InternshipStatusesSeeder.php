<?php

namespace Database\Seeders;

use App\Constants\InternshipStatusConstants;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InternshipStatusesSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        foreach (InternshipStatusConstants::STATUSES as $STATUS) {
            DB::table('internship_statuses')->insert([
                'name' => $STATUS,
                'display_name' => InternshipStatusConstants::STATUSES_DISPLAY_NAME[$STATUS],
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }
    }
}
