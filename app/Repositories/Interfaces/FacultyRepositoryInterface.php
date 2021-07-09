<?php
/**
 * Created by PhpStorm.
 * User: Patryk Jelonek (patryk)
 * Date: 08/07/2021
 * Time: 21:38
 */

namespace App\Repositories\Interfaces;

interface FacultyRepositoryInterface
{
    public function getFaculties();

    public function getFaculty(int $id);

    public function getFacultyByName(string $name);

    public function getFacultyFields(int $id);

    public function getField(int $id);

    public function getSpecialization(int $id);
}
