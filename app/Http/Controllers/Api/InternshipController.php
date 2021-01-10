<?php

namespace App\Http\Controllers\Api;

use App\Models\Agreement;
use App\Http\Controllers\Controller;
use App\Models\InternshipStatus;
use App\Models\Internship;
use App\Models\Offer;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;

class InternshipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $user = User::with(['universities'])->where(['id' => auth()->id()])->first();
        $internships = Agreement::with(['offer', 'company', 'university'])
            ->where(['is_active' => 1])
            ->whereIn('university_id', Arr::pluck($user->toArray()['universities'], 'id'))->get();

        return Response([
            'status' => 'success',
            'data' => $internships,
            'message' => null,
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $internship = new Internship;
        $student = Student::where(['user_id' => auth()->id()])->first();
        $internshipStatus = InternshipStatus::where(['name' => 'new'])->first();

        $internship->offer_id = $request->input('offer.id');
        $internship->agreement_id = $request->input('id');
        $internship->student_id = $student->id;
        $internship->company_supervisor_id = $request->input('offer.company_supervisor_id');
        $internship->university_supervisor_id = $request->input('university_supervisor_id');
        $internship->internship_status_id = $internshipStatus->id;
        $internship->updated_at = date('Y-m-d H:i:s');
        $internship->created_at = date('Y-m-d H:i:s');

        $offer = Offer::find($request->input('offer.id'));
        $offer->places_number--;

        if ($offer->save() and $internship->save()) {
            return response([
                'status' => 'success',
                'data' => $internship,
                'message' => 'Test'
            ], Response::HTTP_OK);
        } else {
            return response([
                'status' => 'error',
                'data' => null,
                'message' => 'Przepraszamy, ale cos poszło nie tak!'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return Response
     */
    public function show($id)
    {
        $internship = Internship::with(['journals.author'])->find($id);

        if (isset($internship))
            return response([
                'status' => 'success',
                'data' => $internship,
                'message' => 'Test'
            ], Response::HTTP_OK);
        else
            return response([
                'status' => 'error',
                'data' => null,
                'message' => 'Przepraszamy, ale cos poszło nie tak!'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Internship $intership
     * @return Response
     */
    public function edit(Internship $intership)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Internship $intership
     * @return Response
     */
    public function update(Request $request, Internship $intership)
    {
        //TODO
    }

    public function confirm($id)
    {
        $internship = Internship::find($id);
        $internshipStatus = InternshipStatus::where(['name' => 'accepted'])->first();

        $internship->internship_status_id = $internshipStatus->id;

        if($internship->save())
            return response([
                'status' => 'success',
                'data' => $internship,
                'message' => null
            ], Response::HTTP_OK);
        else
            return response([
                'status' => 'error',
                'data' => null,
                'message' => 'Przepraszamy, ale cos poszło nie tak!'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Internship $intership
     * @return Response
     */
    public function destroy($id)
    {
        $intership = Internship::find($id);

        if ($intership->delete())
            return response("Internship has been deleted!", Response::HTTP_OK);
        else
            return response("Internship has not been deleted!", Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
