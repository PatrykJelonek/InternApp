<?php

namespace Database\Seeders\Test;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentsTasksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('students_tasks')->insert([
            [
                'student_id' => 1,
                'task_id' => 1,
                'done' => true,
            ],
            [
                'student_id' => 1,
                'task_id' => 2,
                'done' => true,
            ],
            [
                'student_id' => 2,
                'task_id' => 1,
                'done' => false,
            ],
        ]);
    }
}
