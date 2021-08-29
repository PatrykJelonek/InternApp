<?php

namespace App\Repositories\Interfaces;

use App\Models\JournalEntry;

interface StudentRepositoryInterface extends DefaultRepositoryInterface
{
    public function getStudentJournalEntries(int $internshipId, string $studentIndex);

    public function storeStudentJournalEntry(int $internshipId, string $content, array $studentsIds, bool $accepted, string $date): ?JournalEntry;

    public function getAvailableInternshipOffers(int $userId);

    public function createStudentOwnInternship($data);

    public function getStudentByIndex(int $studentIndex);

    public function getStudentUniversities(int $userId);

    public function getStudentByUserId(int $userId);
}
