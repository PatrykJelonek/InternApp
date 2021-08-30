<?php
/**
 * Created by PhpStorm.
 * User: Patryk Jelonek (patryk)
 * Date: 30/08/2021
 * Time: 20:44
 */

namespace App\Repositories\Interfaces;

interface JournalRepositoryInterface
{
    public function getStudentJournalEntryById(int $studentJournalEntryId);

    public function getStudentJournalEntryComments(int $studentJournalEntryId);
}
