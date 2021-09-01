<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentTaskGetStudentTasksRequest;
use App\Http\Resources\Collections\TaskCollection;
use App\Repositories\StudentRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StudentTaskController extends Controller
{
    /**
     * @var StudentRepository
     */
    private $studentRepository;

    /**
     * StudentTaskController constructor.
     *
     * @param StudentRepository $studentRepository
     */
    public function __construct(StudentRepository $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param StudentTaskGetStudentTasksRequest $request
     * @param                                   $internshipId
     * @param                                   $studentIndex
     *
     * @return \Illuminate\Http\Response
     */
    public function getStudentTasks(StudentTaskGetStudentTasksRequest $request, $internshipId, $studentIndex): Response
    {
        $tasks = $this->studentRepository->getStudentTasks($studentIndex);

        if (!empty($tasks)) {
            return response($tasks, Response::HTTP_OK);
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
