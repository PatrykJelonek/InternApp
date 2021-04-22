<?php

namespace App\Http\Controllers\Api;

use App\Constants\AttachmentConstants;
use App\Constants\OfferStatusConstants;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateStudentOwnInternshipRequest;
use App\Http\Requests\StudentGetAvailableInternshipOffersRequest;
use App\Models\Student;
use App\Models\User;
use App\Repositories\AttachmentRepository;
use App\Repositories\CityRepository;
use App\Repositories\CompanyRepository;
use App\Repositories\OfferRepository;
use App\Repositories\OfferStatusRepository;
use App\Repositories\StudentRepository;
use Clockwork\Clockwork;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    /**
     * @var StudentRepository
     */
    private $studentRepository;

    /**
     * @var CompanyRepository
     */
    private $companyRepository;

    /**
     * @var CityRepository
     */
    private $cityRepository;

    /**
     * @var OfferRepository
     */
    private $offerRepository;

    /**
     * @var AttachmentRepository
     */
    private $attachmentRepository;

    /**
     * @var OfferStatusRepository
     */
    private $offerStatusRepository;

    /**
     * StudentController constructor.
     *
     * @param StudentRepository     $studentRepository
     * @param CompanyRepository     $companyRepository
     * @param CityRepository        $cityRepository
     * @param OfferRepository       $offerRepository
     * @param AttachmentRepository  $attachmentRepository
     * @param OfferStatusRepository $offerStatusRepository
     */
    public function __construct(
        StudentRepository $studentRepository,
        CompanyRepository $companyRepository,
        CityRepository $cityRepository,
        OfferRepository $offerRepository,
        AttachmentRepository $attachmentRepository,
        OfferStatusRepository $offerStatusRepository
    ) {
        $this->studentRepository = $studentRepository;
        $this->companyRepository = $companyRepository;
        $this->cityRepository = $cityRepository;
        $this->offerRepository = $offerRepository;
        $this->attachmentRepository = $attachmentRepository;
        $this->offerStatusRepository = $offerStatusRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $students = Student::all();

        if (isset($students)) {
            return response($students, Response::HTTP_OK);
        } else {
            return response("Students not found!", Response::HTTP_NOT_FOUND);
        }
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
     *
     * @return Response
     */
    public function store(Request $request)
    {
        //TODO: Napisać wiadomości zwrotne
        $validatedData = $request->validate(
            [
                'firstName' => 'required|max:64',
                'lastName' => 'required|max:64',
                'phone' => 'required|max:16',
                'email' => 'required|unique:users|max:64',
                'password' => 'required|max:255',
                'index' => 'required|min:0|max:10',
                'year' => 'required|min:0|max:4',
                'semester' => 'required|min:0|max:8',
                'specializationId' => 'required',
                'universityId' => 'required',
            ]
        );

        $user = new User;
        $user->first_name = $request->input("firstName");
        $user->last_name = $request->input("lastName");
        $user->phone_number = $request->input("phone");
        $user->email = $request->input("email");
        $user->password_hash = Hash::make($request->input("password"));
        $user->password_reset_token = Str::random(64);
        $user->remember_token = "remember_token";
        $user->user_status_id = 1;
        $user->created_at = date('Y-m-d H:i:s');
        $user->updated_at = date('Y-m-d H:i:s');

        if ($user->save()) {
            $student = new Student;
            $student->user_id = $user->id;
            $student->student_index = $request->input('index');
            $student->semester = $request->input('semester');
            $student->study_year = $request->input('year');
            $student->specialization_id = $request->input('specializationId');
            $user->created_at = date('Y-m-d H:i:s');
            $user->updated_at = date('Y-m-d H:i:s');

            if ($student->save()) {
                if ($user->attachRole('student')) {
                    $user->universities()->attach(
                        $request->input('universityId'),
                        ['created_at' => date('Y-m-d H:i:s')]
                    );
                    return response(
                        [
                            'status' => 'error',
                            'data' => null,
                            'message' => 'Konto zostało utworzone!',
                        ],
                        Response::HTTP_OK
                    );
                }
                $student->delete();
            }
            $user->delete();
        }

        return response(
            [
                'status' => 'error',
                'data' => null,
                'message' => 'Nie udało się utworzyć konta!',
            ],
            Response::HTTP_INTERNAL_SERVER_ERROR
        );
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
        $student = Student::find($id);

        if (isset($student)) {
            return response($student, Response::HTTP_OK);
        } else {
            return response("Student not found!", Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Student $student
     *
     * @return Response
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Student $student
     *
     * @return Response
     */
    public function update(Request $request, Student $student)
    {
        //TODO: Create method to update student
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $student = Student::find($id);

        if ($student->delete()) {
            return response("Student has been deleted!", Response::HTTP_OK);
        } else {
            return response("Student has not been deleted!", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param StudentGetAvailableInternshipOffersRequest $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response
     */
    public function getAvailableInternshipOffers(StudentGetAvailableInternshipOffersRequest $request)
    {
        $availableInternshipOffers = $this->studentRepository->getAvailableInternshipOffers(Auth::id());

        if (!empty($availableInternshipOffers)) {
            return \response($availableInternshipOffers, Response::HTTP_OK);
        }

        return \response(null, Response::HTTP_NOT_FOUND);
    }

    public function createStudentOwnInternship(CreateStudentOwnInternshipRequest $request)
    {
        $companyRequestData = $request->input('company');
        $cityRequestData = $request->input('company.city');
        $offerRequestData = $request->input('offer');

        DB::beginTransaction();
        try {
            if (empty($companyRequestData['id'])) {
                if (empty($cityRequestData['id'])) {
                    $city = $this->cityRepository->createCity($cityRequestData);

                    if ($city) {
                        $companyRequestData = array_merge(['cityId' => $city->id], $companyRequestData);
                    }
                }

                $company = $this->companyRepository->createCompany($companyRequestData);

                if ($company) {
                    $offerRequestData = array_merge(['companyId' => $company->id], $offerRequestData);
                }
            } else {
                $offerRequestData = array_merge(['companyId' => $companyRequestData['id']], $offerRequestData);
            }

            $offerRequestData = array_merge(['userId' => Auth::user()->id], $offerRequestData);
            $offerRequestData = array_merge(
                [
                    'offerStatusId' => $this->offerStatusRepository->getOfferStatusByName(
                        OfferStatusConstants::STATUS_STUDENT_NEW
                    )->toArray()['id'],
                ],
                $offerRequestData
            );

            $offer = $this->offerRepository->createOffer($offerRequestData);
            if ($offer) {
                if (!empty($request->input('offer.attachments'))) {
                    clock()->info("DUMP", ['dump' => (array)$request->input('offer.attachments')]);
                    $attachment = $this->attachmentRepository->storeAttachments(
                        [
                            'path' => $request->file('offer.attachments')->store(
                                AttachmentConstants::ATTACHMENT_DIR_OFFER
                            ),
                            'name' => $request->file('offer.attachments')->getClientOriginalName(),
                            'extension' => $request->file('offer.attachments')->extension(),
                            'userId' => Auth::id(),
                        ]
                    );

                    if ($attachment) {
                        $this->attachmentRepository->linkOfferAttachments(
                            [
                                'offerId' => $offer->id,
                                'attachmentId' => $attachment->id,
                            ]
                        );
                    }
                }
            } else {
                DB::rollBack();
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            clock()->info(
                'Wystąpił błąd',
                [
                    'method' => 'StudentController::createStudentOwnInternship',
                    'dump' => $exception,
                ]
            );
        }

        if (isset($offer) && $offer) {
            return \response($offer, Response::HTTP_OK);
        }

        return \response(null, Response::HTTP_NOT_FOUND);
    }
}
