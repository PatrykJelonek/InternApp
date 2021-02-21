<?php

namespace App\Repositories;

use App\Models\Student;
use App\Repositories\Interfaces\StudentRepositoryInterface;

class StudentRepository implements StudentRepositoryInterface
{
    /**
     * @param $studentIndex
     * @return mixed
     */
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
            return $student->journalEntries()->orderByDesc('created_at')->get();
        }

        return null;
    }

    /**
     * @param $studentIndex
     * @return mixed
     */
    public function getStudentTasks($studentIndex)
    {
        $student = $this->one($studentIndex);

        if(!empty($student)) {
            return $student->tasks()->orderByDesc('created_at')->get();
        }

        return null;
    }
}
