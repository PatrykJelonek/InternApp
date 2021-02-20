<?php

namespace Database\Seeders\Test;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('students')->insert([
            [
                'user_id' => 2,
                'student_index' => '19234',
                'semester' => 7,
                'study_year' => 4,
                'specialization_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 8,
                'student_index' => '19253',
                'semester' => 7,
                'study_year' => 4,
                'specialization_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
