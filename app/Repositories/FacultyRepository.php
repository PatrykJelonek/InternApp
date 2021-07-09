<?php
/**
 * Created by PhpStorm.
 * User: Patryk Jelonek (patryk)
 * Date: 08/07/2021
 * Time: 21:38
 */

namespace App\Repositories;

use App\Models\Faculty;
use App\Models\Field;
use App\Models\Specialization;
use App\Repositories\Interfaces\FacultyRepositoryInterface;

class FacultyRepository implements FacultyRepositoryInterface
{
    public function getFaculties()
    {
        return Faculty::with(['fields', 'fields.specializations'])->get();
    }

    public function getFaculty(int $id)
    {
        return Faculty::with(['fields', 'fields.specializations'])->find($id);
    }

    public function getFacultyByName(string $name)
    {
        return Faculty::where(['name' => $name])->first();
    }

    public function getFacultyFields(int $id) {
        return Faculty::with(['fields'])->find($id)->fields;
    }

    public function getField(int $id) {
        return Field::find($id);
    }

    public function getSpecialization(int $id)
    {
        return Specialization::find($id);
    }
}
