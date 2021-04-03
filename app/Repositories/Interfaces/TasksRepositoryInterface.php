<?php

namespace App\Repositories\Interfaces;

use App\Models\StudentTask;

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

    public function linkTaskWithStudent(int $taskId, int $studentId, bool $done): ?StudentTask;
}
