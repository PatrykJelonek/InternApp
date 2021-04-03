<?php

namespace App\Repositories\Interfaces;

interface InternshipRepositoryInterface
{
    public function one($id);

    public function all();

    public function getInternshipStudents($id);
}
