<?php
/**
 * Created by PhpStorm.
 * User: Patryk Jelonek (patryk)
 * Date: 23/04/2021
 * Time: 08:36
 */

namespace App\Services;

use App\Models\Offer;
use App\Repositories\StudentRepository;

class StudentServices
{
    /**
     * @var StudentRepository
     */
    private $studentRepository;

    /**
     * StudentServices constructor.
     *
     * @param StudentRepository $studentRepository
     */
    public function __construct(StudentRepository $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }

    /**
     * @param array $data
     *
     * @return Offer
     */
    public function createStudentOwnInternship(array $data): Offer
    {
        //...
    }
}
