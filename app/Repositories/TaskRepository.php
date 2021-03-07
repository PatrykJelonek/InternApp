<?php

namespace App\Repositories;

use App\Models\StudentTask;
use App\Models\Task;
use App\Repositories\Interfaces\TasksRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
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

    public function create(array $resource, array $students_ids = null)
    {
        DB::transaction(function () use($resource, $students_ids) {
            $task = new Task();
            $task->name = $resource['name'];
            $task->description = $resource['description'];
            $task->internship_id = $resource['internship_id'];
            $task->user_id = Auth::user()->id;
            $task->done = $resource['done'];
            $task->created_at = Carbon::today();
            $task->updated_at = Carbon::today();
            $task->save();

            foreach ($students_ids as $student_id) {
                $studentTask = new StudentTask();
                $studentTask->student_id = $student_id;
                $studentTask->task_id = $task->id;
                $studentTask->done = $resource->done;
                $studentTask->created_at = Carbon::today();
                $studentTask->updated_at = Carbon::today();

                $studentTask->save();
            }

            return $task;
        });

        return null;
    }

    public function update(JsonResource $resource)
    {
        // TODO: Implement update() method.
    }

    public function delete(int $id)
    {
        // TODO: Implement delete() method.
    }
}
