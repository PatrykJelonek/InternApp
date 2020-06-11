<?php

use Illuminate\Database\Seeder;

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
            'user_id' => 1,
            'student_index' => '23456',
            'semester' => 7,
            'study_year' => 2017,
            'specialization_id' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('students')->insert([
            'user_id' => 2,
            'student_index' => '23456',
            'semester' => 7,
            'study_year' => 2017,
            'specialization_id' => 2,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('students')->insert([
            'user_id' => 3,
            'student_index' => '34567',
            'semester' => 7,
            'study_year' => 2017,
            'specialization_id' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('students')->insert([
            'user_id' => 11,
            'student_index' => '45677',
            'semester' => 6,
            'study_year' => 2017,
            'specialization_id' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('students')->insert([
            'user_id' => 12,
            'student_index' => '678767',
            'semester' => 6,
            'study_year' => 2017,
            'specialization_id' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}
