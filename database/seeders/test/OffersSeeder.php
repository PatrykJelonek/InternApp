<?php

namespace Database\Seeders\Test;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OffersSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table('offers')->insert(
            [
                [
                    'company_id' => 1,
                    'user_id' => 7,
                    'name' => 'Programista Aplikacji Internetowych w PHP',
                    'places_number' => 2,
                    'program' => 'Praktyki programistyczne',
                    'schedule' => 'Zapoznanie z miejscem pracy. Wdrożenie praktykanata. Systematyczny przydział zadań.',
                    'offer_category_id' => 1,
                    'offer_status_id' => 2,
                    'company_supervisor_id' => 6,
                    'interview' => true,
                    'slug' => Str::slug('Programista Aplikacji Internetowych w PHP'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'company_id' => 2,
                    'user_id' => 6,
                    'name' => 'Staż - Junior PHP Developer',
                    'places_number' => 2,
                    'program' => 'Staż programistyczny jako młodszy programist PHP',
                    'schedule' => 'Zapoznanie z miejscem pracy. Wdrożenie praktykanata. Systematyczny przydział zadań.',
                    'offer_category_id' => 1,
                    'offer_status_id' => 2,
                    'company_supervisor_id' => 6,
                    'interview' => true,
                    'slug' => Str::slug('Staż - Junior PHP Developer'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
            ]
        );
    }
}
