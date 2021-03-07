<?php

namespace App\Repositories\Interfaces;

use App\Repositories\TaskRepository;

interface TasksRepositoryInterface
{
    public function all();

    public function one(int $id);

    public function getByInternship(int $internshipId);

    public function createTask(string $name, string $description, int $internship_id, int $user_id = null, bool $done = false): TaskRepository;
}
