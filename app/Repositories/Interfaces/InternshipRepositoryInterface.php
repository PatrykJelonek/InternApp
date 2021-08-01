<?php

namespace App\Repositories\Interfaces;

interface InternshipRepositoryInterface
{
    /**
     * @param $id
     *
     * @return mixed
     */
    public function getInternship($id);

    /**
     * @return mixed
     */
    public function getInternships();

    /**
     * @param $id
     *
     * @return mixed
     */
    public function getInternshipStudents($id);

    /**
     * @param int $userId
     * @param int $offerId
     * @param int $agreementId
     * @param int $companySupervisorId
     * @param int $universitySupervisorId
     *
     * @return mixed
     */
    public function create(int $userId, int $offerId, int $agreementId, int $companySupervisorId, int $universitySupervisorId);

    public function getInternshipStatuses();

    public function getInternshipStudentByIndex(int $internshipId, string $studentIndex);

    public function getInternshipStatusByName(string $internshipStatusName);
}
