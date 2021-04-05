<?php
/**
 * Created by PhpStorm.
 * User: Patryk Jelonek (patryk)
 * Date: 14/03/2021
 * Time: 20:37
 */

namespace App\Repositories\Interfaces;

interface UniversityRepositoryInterface
{
    public function one(string $slug);

    public function getStudents(string $slug);

    public function getWorkers(string $slug);

    public function getAgreements(string $slug);

    public function getInternships(string $slug);

    public function getSpecializations(string $slug);

    public function getFaculties(string $slug);
}
