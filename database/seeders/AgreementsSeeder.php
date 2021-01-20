<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AgreementsSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {

        DB::table('agreements')->insert([
        	'signing_date' => date('Y-m-d H:i:s'),
        	'date_from' => date('Y-m-d H:i:s'),
            'date_to' => date('Y-m-d H:i:s'),
            'program' => 'Praktyki programistyczne',
            'schedule' => 'Zapoznanie z miejscem pracy. Wdrożenie praktykanata. Systematyczny przydział zadań.',
            'content' =>'Zapoznanie z miejscem pracy. Wdrożenie praktykanata. Systematyczny przydział zadań.',
            'company_id' => 1,
            'university_id' => 1,
            'university_supervisor_id' => 4,
            'offer_id' => 1,
            'is_active' => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);


        DB::table('agreements')->insert([
        	'signing_date' => date('Y-m-d H:i:s'),
        	'date_from' => date('Y-m-d H:i:s'),
            'date_to' => date('Y-m-d H:i:s'),
            'program' => 'Praktyki nadzorowania sieci komputerowych.',
            'schedule' => 'Zapoznanie z miejscem pracy. Wdrożenie praktykanata. Systematyczny przydział zadań.',
            'content' =>'Zapoznanie z miejscem pracy. Wdrożenie praktykanata. Systematyczny przydział zadań.',
            'company_id' => 2,
            'university_id' => 1,
            'university_supervisor_id' => 5,
            'offer_id' => 2,
            'is_active' => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

    }
}

