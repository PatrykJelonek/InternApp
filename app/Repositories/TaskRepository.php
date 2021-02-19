<?php

namespace App\Repositories;

use App\Models\Task;
use App\Repositories\Interfaces\TasksRepositoryInterface;

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
}
