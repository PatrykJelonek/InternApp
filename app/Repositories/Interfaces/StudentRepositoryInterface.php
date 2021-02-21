<?php

namespace App\Repositories\Interfaces;

interface StudentRepositoryInterface
{
    public function one($id);

    public function all();

    public function getStudentJournalEntries($studentId);
}
