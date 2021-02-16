<?php

namespace App\Repositories;

use App\Http\Resources\Collections\TaskCollection;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Repositories\Interfaces\TasksRepositoryInterface;

class TaskRepository implements TasksRepositoryInterface
{

    public function all()
    {
        return new TaskCollection(Task::all());
    }

    public function one(int $id)
    {
        return new TaskResource(Task::find($id));
    }

    public function getByInternship(int $internshipId)
    {
        return new TaskCollection(Task::where('internship_id',$internshipId)->get());
    }
}
