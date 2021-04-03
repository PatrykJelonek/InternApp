<?php

namespace App\Services;

use App\Models\Task;

class TaskService
{
    public function isAuthor(Task $task, int $user_id): bool
    {
        return $task->user_id === $user_id;
    }

    public function canShow(Task $task, int $user_id): bool
    {
        if($task->internship->company_supervisor_id === $user_id) {
            return true;
        }

        if($task->internship->university_supervisor_id === $user_id) {
            return true;
        }

        if($task->internship->company_supervisor_id === $user_id) {
            return true;
        }

        return false;
    }
}
