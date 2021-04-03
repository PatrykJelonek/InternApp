<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Collections\StudentCollection;
use App\Repositories\InternshipRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class InternshipStudentController extends Controller
{
    /**
     * @var InternshipRepository
     */
    private $internshipRepository;

    /**
     * InternshipStudentController constructor.
     * @param InternshipRepository $internshipRepository
     */
    public function __construct(InternshipRepository $internshipRepository)
    {
        $this->internshipRepository = $internshipRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param $id
     * @return mixed
     */
    public function index($id)
    {
        $internshipStudents = $this->internshipRepository->getInternshipStudents($id);

        if(!empty($internshipStudents)) {
            return response(new StudentCollection($internshipStudents));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
