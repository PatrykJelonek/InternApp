<?php

namespace App\Repositories;

use App\Models\StudentTask;
use App\Models\Task;
use App\Models\User;
use App\Notifications\JournalEntryCreated;
use App\Notifications\TaskCreated;
use App\Repositories\Interfaces\TasksRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

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
        return Task::where('internship_id', $internshipId)->get();
    }

    public function delete(int $id)
    {
        // TODO: Implement delete() method.
    }

    public function update(array $data)
    {
        // TODO: Implement update() method.
    }

    public function create(array $data, int $internshipId, ?int $studentId = null): ?Task
    {
        try {
            DB::beginTransaction();

            $task = new Task();
            $task->name = $data['name'];
            $task->description = $data['description'];
            $task->internship_id = $internshipId;
            $task->user_id = Auth::user()->id;
            $task->done = $data['done'];
            $task->created_at = Carbon::today();
            $task->updated_at = Carbon::today();
            $task->save();

            if (isset($data['students_ids']) && is_array($data['students_ids'])) {
//                if($studentId !== null) {
//                    if(!in_array($studentId, $data['students_ids'])) {
//                        $this->linkTaskWithStudent($task->id, $studentId, $data['done']);
//                    }
//                }

                if (!empty($data['students_ids'])) {
                    foreach ($data['students_ids'] as $student_id) {
                        $studentTask = $this->linkTaskWithStudent($task->id, $student_id, $data['done']);

                        if ($studentTask !== null) {
                            Notification::send($studentTask->student->user, new TaskCreated($task));
                        }
                    }
                }
            }

            DB::commit();
            return $task;
        } catch (\Exception $exception) {
            DB::rollBack();
            return null;
        }
    }

    public function linkTaskWithStudent(int $taskId, int $studentId, bool $done): ?StudentTask
    {
        $studentTask = new StudentTask();
        $studentTask->student_id = $studentId;
        $studentTask->task_id = $taskId;
        $studentTask->done = $done;
        $studentTask->created_at = Carbon::today();
        $studentTask->updated_at = Carbon::today();

        if ($studentTask->save()) {
            return $studentTask;
        }

        return null;
    }
}
