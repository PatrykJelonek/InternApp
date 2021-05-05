<?php

namespace App\Repositories\Interfaces;

interface UserRepositoryInterface
{
    /**
     * @param int   $userId
     * @param array $status Array of Internship Statuses
     *
     * @return mixed
     */
    public function getInternships(int $userId, array $status = null);

    public function getUniversities();

    public function getCompanies();

    public function getMessages(int $userId);
}
