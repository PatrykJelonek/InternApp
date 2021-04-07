<?php

namespace App\Http\Controllers\api;

use App\Repositories\StudentRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{
    /**
     * @var StudentRepository
     */
    private $studentRepository;

    public function __construct(StudentRepository $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }

    public function test() {
        return \response($this->studentRepository->getAvailableInternshipOffers(Auth::id()),Response::HTTP_OK);
    }
}
