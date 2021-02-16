<?php

namespace Database\Seeders;

use App\Models\InternshipStatus;
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
        foreach (InternshipStatus::STATUSES as $STATUS) {
            DB::table('internship_statuses')->insert([
                'name' => $STATUS,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }
    }
}
