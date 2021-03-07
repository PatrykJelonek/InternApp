<?php

namespace App\Repositories\Interfaces;

use App\Repositories\TaskRepository;

interface TasksRepositoryInterface extends DefaultRepositoryInterface
{
    public function getByInternship(int $internshipId);
}
