<?php

namespace Database\Seeders\Test;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InternshipsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('internships')->insert(
            [
                [
                    'offer_id' => 1,
                    'agreement_id' => 1,
                    'student_id' => 1,
                    'company_supervisor_id' => 6,
                    'university_supervisor_id' => 3,
                    'interview_date' => Carbon::today()->addDays(23),
                    'internship_status_id' => 2,
                    'created_at' => Carbon::today(),
                    'updated_at' => Carbon::today()
                ],
            ]
        );
    }
}
