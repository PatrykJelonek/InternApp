<?php

namespace Database\Seeders\Test;

use Carbon\Carbon;
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
                'done_at' => null
            ],
            [
                'student_id' => 1,
                'task_id' => 2,
                'done_at' => Carbon::today()->addDays(2),
            ],
            [
                'student_id' => 2,
                'task_id' => 1,
                'done_at' => Carbon::today()->addDays(2),
            ],
        ]);
    }
}
