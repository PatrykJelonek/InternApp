<?php

use Illuminate\Database\Seeder;

class InternshipsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('internships')->insert([
            'offer_id' => 1,
            'student_id' => 1,
            'company_supervisor_id' => 6,
            'university_supervisor_id' => 4,//dyrektor instytutu
            'grade' => 5,
            'interview_date' => date('Y-m-d H:i:s'),
            'internship_status_id' => 7,//oczekująca na zakończenie
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('internships')->insert([
            'offer_id' => 1,
            'student_id' => 2,
            'company_supervisor_id' => 6,
            'university_supervisor_id' => 4,
            'grade' => 5,
            'interview_date' => date('Y-m-d H:i:s'),
            'internship_status_id' => 7,//oczekująca na zakończenie
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('internships')->insert([
            'offer_id' => 2,
            'student_id' => 3,
            'company_supervisor_id' => 9,
            'university_supervisor_id' => 4,
            'grade' => 5,
            'interview_date' => date('Y-m-d H:i:s'),
            'internship_status_id' => 3,//zaliczona
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}