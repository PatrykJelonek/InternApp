<?php

namespace Database\Seeders\Test;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
                    'signing_date' => Carbon::today()->subDays(20),
                    'date_from' => Carbon::today()->subDays(15),
                    'date_to' => Carbon::today()->subDays(15)->addMonths(6),
                    'name' => 'PHP Developer - Staż',
                    'program' => 'Praktyki programistyczne',
                    'schedule' => 'Zapoznanie z miejscem pracy. Wdrożenie praktykanata. Systematyczny przydział zadań.',
                    'content' => 'Zapoznanie z miejscem pracy. Wdrożenie praktykanata. Systematyczny przydział zadań.',
                    'company_id' => 1,
                    'university_id' => 1,
                    'university_supervisor_id' => 3,
                    'offer_id' => 1,
                    'user_id' => 5,
                    'is_active' => true,
                    'slug' => Str::slug('Programista Aplikacji Internetowych w PHP'),
                    'created_at' => Carbon::today(),
                    'updated_at' => Carbon::today(),
                ],
                [
                    'signing_date' => Carbon::today()->subDays(20),
                    'date_from' => Carbon::today()->subDays(15),
                    'date_to' => Carbon::today()->subDays(15)->addMonths(6),
                    'name' => 'Staż u Agusi',
                    'program' => 'Praktyki programistyczne',
                    'schedule' => 'Zapoznanie z miejscem pracy. Wdrożenie praktykanata. Systematyczny przydział zadań.',
                    'content' => 'Zapoznanie z miejscem pracy. Wdrożenie praktykanata. Systematyczny przydział zadań.',
                    'company_id' => 2,
                    'university_id' => 1,
                    'university_supervisor_id' => 9,
                    'offer_id' => 2,
                    'user_id' => 5,
                    'is_active' => true,
                    'slug' => Str::slug('Staż - Junior PHP Developer'),
                    'created_at' => Carbon::today(),
                    'updated_at' => Carbon::today(),
                ],
            ]
        );
    }
}

