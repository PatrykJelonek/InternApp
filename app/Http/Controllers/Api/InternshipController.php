<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInternshipRequest;
use App\Http\Resources\InternshipResource;
use App\Models\Agreement;
use App\Models\Internship;
use App\Models\InternshipStatus;
use App\Models\Offer;
use App\Models\Student;
use App\Models\User;
use App\Repositories\InternshipRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class InternshipController extends Controller
{
    /**
     * @var InternshipRepository
     */
    private $internshipRepository;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * InternshipController constructor.
     *
     * @param InternshipRepository $internshipRepository
     * @param UserRepository       $userRepository
     */
    public function __construct(InternshipRepository $internshipRepository, UserRepository $userRepository)
    {
        $this->internshipRepository = $internshipRepository;
        $this->userRepository = $userRepository;
    }

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

        return Response(
            [
                'status' => 'success',
                'data' => $internships,
                'message' => null,
            ],
            Response::HTTP_OK
        );
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
     * @param StoreInternshipRequest $request
     *
     * @return Response
     */
    public function store(StoreInternshipRequest $request)
    {
        $result = $this->internshipRepository->create(
            Auth::user()->id,
            $request->input('offerId'),
            $request->input('agreementId'),
            $request->input('companySupervisorId'),
            $request->input('universitySupervisorId')
        );

        if (!empty($result)) {
            return \response($result, Response::HTTP_OK);
        }

        return \response(null, Response::HTTP_NOT_FOUND);
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     *
     * @return Response
     */
    public function show($id)
    {
        $internship = $this->internshipRepository->one($id);

        if (!empty($internship)) {
            return response(new InternshipResource($internship), Response::HTTP_OK);
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Internship $intership
     *
     * @return Response
     */
    public function edit(Internship $intership)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request    $request
     * @param Internship $intership
     *
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

        if ($internship->save()) {
            return response(
                [
                    'status' => 'success',
                    'data' => $internship,
                    'message' => null,
                ],
                Response::HTTP_OK
            );
        } else {
            return response(
                [
                    'status' => 'error',
                    'data' => null,
                    'message' => 'Przepraszamy, ale cos poszło nie tak!',
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Internship $intership
     *
     * @return Response
     */
    public function destroy($id)
    {
        $intership = Internship::find($id);

        if ($intership->delete()) {
            return response("Internship has been deleted!", Response::HTTP_OK);
        } else {
            return response("Internship has not been deleted!", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
