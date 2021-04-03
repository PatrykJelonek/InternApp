<?php

namespace Database\Seeders\Test;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InternshipsStudentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('internships_students')->insert(
            [
                [
                    'internship_id' => 1,
                    'student_id' => 1,
                    'grade' => null,
                    'interview_date' => null,
                ],
                [
                    'internship_id' => 2,
                    'student_id' => 1,
                    'grade' => null,
                    'interview_date' => null,
                ],
                [
                    'internship_id' => 1,
                    'student_id' => 2,
                    'grade' => null,
                    'interview_date' => null,
                ],
            ]
        );
    }
}
