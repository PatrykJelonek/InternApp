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
use Illuminate\Database\Eloquent\Model;

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
     * @param int    $universityId
     *
     * @return Faculty|null
     */
    public function createFaculty(string $name, int $universityId): ?Faculty
    {
        $existingFaculty = $this->repository->getFacultyByName($name);

        if ($existingFaculty === null) {
            $faculty = new Faculty();
            $faculty->name = $name;
            $faculty->university_id = $universityId;
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
     * @param int    $facultyId
     *
     * @return Field|null
     */
    public function createFacultyField(string $name, int $facultyId): ?Field
    {
        $field = new Field();
        $field->name = $name;
        $field->faculty_id = $facultyId;
        $field->freshTimestamp();

        if ($field->save()) {
            return $field;
        }

        return null;
    }

    /**
     * @param string $name
     * @param int    $fieldId
     *
     * @return Specialization|null
     */
    public function createFieldSpecialization(string $name, int $fieldId): ?Specialization
    {
        $specialization = new Specialization();
        $specialization->name = $name;
        $specialization->field_id = $fieldId;
        $specialization->freshTimestamp();

        if ($specialization->save()) {
            return $specialization;
        }

        return null;
    }

    /**
     * @param string $name
     * @param int    $facultyId
     *
     * @return Faculty|null
     */
    public function updateFaculty(string $name, int $facultyId): ?Faculty
    {
        $faculty = $this->repository->getFaculty($facultyId);
        $faculty->name = $name;
        $faculty->updateTimestamps();

        if ($faculty->save()) {
            return $faculty;
        }

        return null;
    }

    /**
     * @param string $name
     * @param int    $fieldId
     *
     * @return Field|null
     */
    public function updateFacultyField(string $name, int $fieldId): ?Field
    {
        $field = $this->repository->getField($fieldId);
        $field->name = $name;
        $field->updateTimestamps();

        if ($field->save()) {
            return $field;
        }

        return null;
    }

    /**
     * @param string $name
     * @param int    $specializationId
     *
     * @return Specialization|null
     */
    public function updateFieldSpecialization(string $name, int $specializationId): ?Specialization
    {
        $specialization = $this->repository->getSpecialization($specializationId);
        $specialization->name = $name;
        $specialization->updateTimestamps();

        if ($specialization->save()) {
            return $specialization;
        }

        return null;
    }
}
