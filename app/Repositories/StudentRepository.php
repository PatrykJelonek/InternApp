<?php

namespace App\Repositories;

use App\Models\Student;
use App\Repositories\Interfaces\StudentRepositoryInterface;

class StudentRepository implements StudentRepositoryInterface
{
    public function one($studentIndex)
    {
        return Student::where('student_index', $studentIndex)->first();
    }

    public function all()
    {
        // TODO: Implement all() method.
    }

    /**
     * @param $studentIndex
     * @return mixed
     */
    public function getStudentJournalEntries($studentIndex)
    {
        $student = $this->one($studentIndex);

        if(!empty($student)) {
            return $student->journalEntries;
        }

        return null;
    }
}
