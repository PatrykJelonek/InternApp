<?php

namespace App\Repositories\Interfaces;

use App\Repositories\TaskRepository;

interface TasksRepositoryInterface extends DefaultRepositoryInterface
{
    public function getByInternship(int $internshipId);

    /**
     * @param array $data
     * @param int $internshipId
     * @param int|null $studentId
     * @return mixed
     */
    public function create(array $data, int $internshipId, ?int $studentId = null);
}
