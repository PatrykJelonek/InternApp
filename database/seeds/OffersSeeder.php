<?php

use Illuminate\Database\Seeder;

class OffersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            	
        DB::table('offers')->insert([
        	'company_id' => 1,
        	'user_id' => 7,
            'name' => 'Praktyka studencka',
            'places_number' => 2,        
            'program' => 'Praktyki programistyczne',
            'schedule' =>'Zapoznanie z miejscem pracy. Wdrożenie praktykanata. Systematyczny przydział zadań.',
            'offer_category_id' => 1,
            'offer_status_id' => 2,
            'company_supervisor_id' => 7,
            'interview' => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('offers')->insert([
        	'company_id' => 2,
        	'user_id' => 10,
            'name' => 'Praktyka studencka',
            'places_number' => 1,        
            'program' => 'Praktyki nadzorowania sieci komputerowych.',
            'schedule' =>'Zapoznanie z miejscem pracy. Wdrożenie praktykanata. Systematyczny przydział zadań.',
            'offer_category_id' => 1,
            'offer_status_id' => 2,
            'company_supervisor_id' => 10,
            'interview' => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('offers')->insert([
            'company_id' => 3,
            'user_id' => 4,
            'name' => 'Praktyka studencka',
            'places_number' => 5,        
            'program' => 'Praktyki w dziale IT',
            'schedule' =>'Zapoznanie z miejscem pracy. Wdrożenie praktykanata. Systematyczny przydział zadań.',
            'offer_category_id' => 1,
            'offer_status_id' => 2,
            'company_supervisor_id' => 7,
            'interview' => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
             
    }
}