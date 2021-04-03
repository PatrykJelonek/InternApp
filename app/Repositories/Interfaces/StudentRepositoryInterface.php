<?php

namespace App\Repositories\Interfaces;

use App\Models\JournalEntry;

interface StudentRepositoryInterface extends DefaultRepositoryInterface
{
    public function getStudentJournalEntries($studentId);

    public function storeStudentJournalEntry(int $internshipId, string $content, array $studentsIds, bool $accepted, string $date): ?JournalEntry;
}
