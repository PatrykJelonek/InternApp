<?php

namespace App\Repositories\Interfaces;

interface TasksRepositoryInterface
{
    public function all();

    public function one(int $id);

    public function getByInternship(int $internshipId);
}
