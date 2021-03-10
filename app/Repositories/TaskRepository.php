<?php

namespace App\Repositories;

use App\Models\StudentTask;
use App\Models\Task;
use App\Repositories\Interfaces\TasksRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TaskRepository implements TasksRepositoryInterface
{

    public function all()
    {
        return Task::all();
    }

    public function one(int $id)
    {
        return Task::find($id);
    }

    public function getByInternship(int $internshipId)
    {
        return Task::where('internship_id',$internshipId)->get();
    }

    public function delete(int $id)
    {
        // TODO: Implement delete() method.
    }

    public function update(array $data)
    {
        // TODO: Implement update() method.
    }

    public function create(array $data, int $internshipId, ?int $studentId = null)
    {
        DB::transaction(function () use($data, $internshipId, $studentId) {
            $task = new Task();
            $task->name = $data['name'];
            $task->description = $data['description'];
            $task->internship_id = $internshipId;
            $task->user_id = Auth::user()->id;
            $task->done = $data['done'];
            $task->created_at = Carbon::today();
            $task->updated_at = Carbon::today();
            $task->save();

            if($data['students_ids'] !== null) {
                foreach ($data['students_ids'] as $student_id) {
                    $studentTask = new StudentTask();
                    $studentTask->student_id = $student_id;
                    $studentTask->task_id = $task->id;
                    $studentTask->done = $data['done'];
                    $studentTask->created_at = Carbon::today();
                    $studentTask->updated_at = Carbon::today();

                    $studentTask->save();
                }
            }

            return $task;
        });

        return null;
    }
}
