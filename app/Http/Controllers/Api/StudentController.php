<?php

namespace App\Http\Controllers\Api;

use App\Constants\AgreementStatusConstants;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateStudentOwnInternshipRequest;
use App\Http\Requests\StudentGetAvailableInternshipOffersRequest;
use App\Http\Requests\StudentGetStudentUniversitiesRequest;
use App\Models\Student;
use App\Models\User;
use App\Repositories\AgreementStatusRepository;
use App\Repositories\InternshipRepository;
use App\Repositories\StudentRepository;
use App\Repositories\UniversityRepository;
use App\Services\AgreementService;
use App\Services\CityService;
use App\Services\CompanyService;
use App\Services\InternshipService;
use App\Services\StudentService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    public const REQUEST_FIELD_OWN_INTERNSHIP_COMPANY_ID = 'company.id';
    public const REQUEST_FIELD_OWN_INTERNSHIP_COMPANY_NAME = 'company.name';
    public const REQUEST_FIELD_OWN_INTERNSHIP_COMPANY_STREET = 'company.street';
    public const REQUEST_FIELD_OWN_INTERNSHIP_COMPANY_STREET_NUMBER = 'company.streetNumber';
    public const REQUEST_FIELD_OWN_INTERNSHIP_COMPANY_EMAIL = 'company.email';
    public const REQUEST_FIELD_OWN_INTERNSHIP_COMPANY_PHONE = 'company.phone';
    public const REQUEST_FIELD_OWN_INTERNSHIP_COMPANY_WEBSITE = 'company.website';
    public const REQUEST_FIELD_OWN_INTERNSHIP_COMPANY_DESCRIPTION = 'company.description';
    public const REQUEST_FIELD_OWN_INTERNSHIP_COMPANY_CATEGORY_ID = 'company.companyCategoryId';
    public const REQUEST_FIELD_OWN_INTERNSHIP_COMPANY_CITY_ID = 'company.city.id';
    public const REQUEST_FIELD_OWN_INTERNSHIP_COMPANY_CITY_NAME = 'company.city.name';
    public const REQUEST_FIELD_OWN_INTERNSHIP_COMPANY_CITY_POSTCODE = 'company.city.postcode';
    public const REQUEST_FIELD_OWN_INTERNSHIP_AGREEMENT_NAME = 'agreement.name';
    public const REQUEST_FIELD_OWN_INTERNSHIP_AGREEMENT_PROGRAM = 'agreement.program';
    public const REQUEST_FIELD_OWN_INTERNSHIP_AGREEMENT_SCHEDULE = 'agreement.schedule';
    public const REQUEST_FIELD_OWN_INTERNSHIP_AGREEMENT_CATEGORY_ID = 'agreement.offerCategoryId';
    public const REQUEST_FIELD_OWN_INTERNSHIP_AGREEMENT_DATE_FROM = 'agreement.dateFrom';
    public const REQUEST_FIELD_OWN_INTERNSHIP_AGREEMENT_DATE_TO = 'agreement.dateTo';
    public const REQUEST_FIELD_OWN_INTERNSHIP_AGREEMENT_ATTACHMENTS = 'agreement.attachment';
    public const REQUEST_FIELD_OWN_INTERNSHIP_AGREEMENT_UNIVERSITY_SLUG = 'agreement.universitySlug';
    public const OWN_INTERNSHIP_COMPANY_DRAFT = true;
    public const OWN_INTERNSHIP_COMPANY_VERIFIED = false;
    public const OWN_INTERNSHIP_AGREEMENT_DEFAULT_PLACES_NUMBER = 1;
    public const OWN_INTERNSHIP_AGREEMENT_IS_NOT_ACTIVE = false;


    /**
     * @var StudentRepository
     */
    private $studentRepository;

    /**
     * @var StudentService
     */
    private $studentServices;

    /**
     * @var CompanyService
     */
    private $companyService;

    /**
     * @var CityService
     */
    private $cityService;

    /**
     * @var AgreementService
     */
    private $agreementService;

    /**
     * @var AgreementStatusRepository
     */
    private $agreementStatusRepository;

    /**
     * @var UniversityRepository
     */
    private $universityRepository;

    /**
     * @var InternshipService
     */
    private $internshipService;

    /**
     * @var InternshipRepository
     */
    private $internshipRepository;

    /**
     * StudentController constructor.
     *
     * @param StudentRepository         $studentRepository
     * @param StudentService            $studentServices
     * @param CompanyService            $companyService
     * @param CityService               $cityService
     * @param AgreementService          $agreementService
     * @param AgreementStatusRepository $agreementStatusRepository
     * @param UniversityRepository      $universityRepository
     * @param InternshipService         $internshipService
     * @param InternshipRepository      $internshipRepository
     */
    public function __construct(
        StudentRepository $studentRepository,
        StudentService $studentServices,
        CompanyService $companyService,
        CityService $cityService,
        AgreementService $agreementService,
        AgreementStatusRepository $agreementStatusRepository,
        UniversityRepository $universityRepository,
        InternshipService $internshipService,
        InternshipRepository $internshipRepository
    ) {
        $this->studentRepository = $studentRepository;
        $this->studentServices = $studentServices;
        $this->companyService = $companyService;
        $this->cityService = $cityService;
        $this->agreementService = $agreementService;
        $this->agreementStatusRepository = $agreementStatusRepository;
        $this->universityRepository = $universityRepository;
        $this->internshipService = $internshipService;
        $this->internshipRepository = $internshipRepository;
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
        $companyId = $request->input(self::REQUEST_FIELD_OWN_INTERNSHIP_COMPANY_ID);

        DB::beginTransaction();
        if (empty($companyId)) {

            $cityId = $request->input(self::REQUEST_FIELD_OWN_INTERNSHIP_COMPANY_CITY_ID);

            if (empty($cityId)) {
                $city = $this->cityService->createCity(
                    $request->input(self::REQUEST_FIELD_OWN_INTERNSHIP_COMPANY_CITY_NAME),
                    $request->input(self::REQUEST_FIELD_OWN_INTERNSHIP_COMPANY_CITY_POSTCODE)
                );

                if (is_null($city)) {
                    DB::rollBack();
                    return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
                }

                $cityId = $city->id;
            }


            $company = $this->companyService->createCompany(
                $request->input(self::REQUEST_FIELD_OWN_INTERNSHIP_COMPANY_NAME),
                $cityId,
                $request->input(self::REQUEST_FIELD_OWN_INTERNSHIP_COMPANY_STREET),
                $request->input(self::REQUEST_FIELD_OWN_INTERNSHIP_COMPANY_STREET_NUMBER),
                $request->input(self::REQUEST_FIELD_OWN_INTERNSHIP_COMPANY_EMAIL),
                $request->input(self::REQUEST_FIELD_OWN_INTERNSHIP_COMPANY_CATEGORY_ID),
                $request->input(self::REQUEST_FIELD_OWN_INTERNSHIP_COMPANY_PHONE),
                $request->input(self::REQUEST_FIELD_OWN_INTERNSHIP_COMPANY_WEBSITE),
                $request->input(self::REQUEST_FIELD_OWN_INTERNSHIP_COMPANY_DESCRIPTION),
                self::OWN_INTERNSHIP_COMPANY_VERIFIED,
                Auth::user()->id,
                self::OWN_INTERNSHIP_COMPANY_DRAFT,
            );

            if (is_null($company)) {
                DB::rollBack();
                return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            $companyId = $company->id;
        }

        $university = $this->universityRepository->getUniversityBySlug(
            $request->input(self::REQUEST_FIELD_OWN_INTERNSHIP_AGREEMENT_UNIVERSITY_SLUG)
        );

        $universityWorkers = $this->universityRepository
            ->getWorkers(
                $request->input(self::REQUEST_FIELD_OWN_INTERNSHIP_AGREEMENT_UNIVERSITY_SLUG)
            )->toArray();

        $agreementStatus = $this->agreementStatusRepository
            ->getStatusByName(
                AgreementStatusConstants::STATUS_ACCEPTED
            );

        $randomUniversityWorkerId = $universityWorkers[array_rand($universityWorkers)]['id'];

        $agreement = $this->agreementService->createAgreement(
            $request->input(self::REQUEST_FIELD_OWN_INTERNSHIP_AGREEMENT_NAME),
            $request->input(self::REQUEST_FIELD_OWN_INTERNSHIP_AGREEMENT_DATE_FROM),
            $request->input(self::REQUEST_FIELD_OWN_INTERNSHIP_AGREEMENT_DATE_TO),
            $request->input(self::REQUEST_FIELD_OWN_INTERNSHIP_AGREEMENT_PROGRAM),
            $companyId,
            $university->id,
            $randomUniversityWorkerId,
            self::OWN_INTERNSHIP_AGREEMENT_DEFAULT_PLACES_NUMBER,
            $request->input(self::REQUEST_FIELD_OWN_INTERNSHIP_AGREEMENT_SCHEDULE),
            null,
            null,
            self::OWN_INTERNSHIP_AGREEMENT_IS_NOT_ACTIVE,
            null,
            $agreementStatus->id,
        );

        if (!is_null($agreement)) {
            $internship = $this->internshipService->createInternship(
                $agreement->id,
                null,
                $randomUniversityWorkerId,
            );

            $student = $this->studentRepository->getStudentByUserId(Auth::id());

            if (!is_null($internship) && !is_null($student)) {
                $internship->students()->attach($student->id);

                DB::commit();
                return response($internship, Response::HTTP_CREATED);
            }
        }

        return \response(null, Response::HTTP_NOT_FOUND);
    }

    public function getStudentUniversities(StudentGetStudentUniversitiesRequest $request)
    {
        return response(
            $this->studentRepository->getStudentUniversities(Auth::user()->id),
            Response::HTTP_OK
        );
    }
}
