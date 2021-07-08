<?php
/**
 * Created by PhpStorm.
 * User: Patryk Jelonek (patryk)
 * Date: 08/07/2021
 * Time: 22:04
 */

namespace App\Services;

use App\Models\Faculty;
use App\Models\Field;
use App\Models\Specialization;
use App\Repositories\FacultyRepository;

class FacultyService
{
    /**
     * @var FacultyRepository
     */
    private $repository;

    /**
     * FacultyService constructor.
     *
     * @param FacultyRepository $repository
     */
    public function __construct(FacultyRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param string $name
     *
     * @return Faculty|null
     */
    public function createFaculty(string $name): ?Faculty
    {
        $existingFaculty = $this->repository->getFacultyByName($name);

        if ($existingFaculty === null) {
            $faculty = new Faculty();
            $faculty->name = $name;
            $faculty->freshTimestamp();

            if ($faculty->save()) {
                return $faculty;
            }

            return null;
        }

        return $existingFaculty;
    }

    /**
     * @param string $name
     *
     * @return Field|null
     */
    public function createFacultyField(string $name): ?Field
    {
        $field = new Field();
        $field->name = $name;
        $field->freshTimestamp();

        if ($field->save()) {
            return $field;
        }

        return null;
    }

    /**
     * @param string $name
     * @param string $description
     *
     * @return Specialization|null
     */
    public function createFieldSpecialization(string $name, string $description): ?Specialization
    {
        $specialization = new Specialization();
        $specialization->name = $name;
        $specialization->description = $description;
        $specialization->freshTimestamp();

        if ($specialization->save()) {
            return $specialization;
        }

        return null;
    }
}
