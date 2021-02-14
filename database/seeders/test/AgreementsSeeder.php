<?php

namespace Database\Seeders\Test;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AgreementsSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table('agreements')->insert(
            [
                [
                    'signing_date' => Carbon::today()->addDays(4),
                    'date_from' => Carbon::today()->addDays(15),
                    'date_to' => Carbon::today()->addDays(15)->addMonths(6),
                    'program' => 'Praktyki programistyczne',
                    'schedule' => 'Zapoznanie z miejscem pracy. Wdrożenie praktykanata. Systematyczny przydział zadań.',
                    'content' => 'Zapoznanie z miejscem pracy. Wdrożenie praktykanata. Systematyczny przydział zadań.',
                    'company_id' => 1,
                    'university_id' => 1,
                    'university_supervisor_id' => 3,
                    'offer_id' => 1,
                    'user_id' => 5,
                    'is_active' => true,
                    'created_at' => Carbon::today(),
                    'updated_at' => Carbon::today(),
                ],
            ]
        );
    }
}

