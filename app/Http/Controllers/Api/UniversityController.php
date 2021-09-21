<?php

namespace App\Http\Controllers\Api;

use App\Constants\AgreementStatusConstants;
use App\Constants\RoleConstants;
use App\Events\StudentRejected;
use App\Events\StudentVerified;
use App\Events\UniversityRejected;
use App\Events\UniversityVerified;
use App\Events\UniversityWorkerRejected;
use App\Events\UniversityWorkerVerified;
use App\Http\Controllers\Controller;
use App\Http\Requests\UniversityAddStudentToUniversityRequest;
use App\Http\Requests\UniversityAddUserToUniversityRequest;
use App\Http\Requests\UniversityAddWorkerToUniversityRequest;
use App\Http\Requests\UniversityAgreementsRequest;
use App\Http\Requests\UniversityChangeUniversityWorkerRolesRequest;
use App\Http\Requests\UniversityCreateOwnAgreementRequest;
use App\Http\Requests\UniversityCreateUniversityFacultyFieldRequest as CreateFieldRequest;
use App\Http\Requests\UniversityCreateUniversityFacultyFieldSpecializationRequest as CreateSpecializationRequest;
use App\Http\Requests\UniversityCreateUniversityFacultyRequest as CreateFacultyRequest;
use App\Http\Requests\UniversityCreateUniversityQuestionnaireRequest;
use App\Http\Requests\RoleGetAvailableRolesByGroupRequest;
use App\Http\Requests\UniversityCreateUniversityRequest;
use App\Http\Requests\UniversityGetUniversitiesToVerificationRequest;
use App\Http\Requests\UniversityGetUniversityOffersRequest;
use App\Http\Requests\UniversityGetUniversityQuestionnairesRequest;
use App\Http\Requests\UniversityGetUniversityRequest;
use App\Http\Requests\UniversityInternshipsRequest;
use App\Http\Requests\UniversityRejectStudentInUniversityRequest;
use App\Http\Requests\UniversityRejectUniversityRequest;
use App\Http\Requests\UniversityRejectUniversityWorkerRequest;
use App\Http\Requests\UniversityStudentsRequest;
use App\Http\Requests\UniversityUpdateUniversityDataRequest;
use App\Http\Requests\UniversityUpdateUniversityFacultyFieldRequest;
use App\Http\Requests\UniversityUpdateUniversityFacultyFieldSpecializationRequest;
use App\Http\Requests\UniversityUpdateUniversityFacultyRequest;
use App\Http\Requests\UniversityUpdateUniversityLogoRequest as UpdateLogoRequest;
use App\Http\Requests\UniversityVerifyStudentInUniversityRequest;
use App\Http\Requests\UniversityVerifyUniversityRequest;
use App\Http\Requests\UniversityVerifyUniversityWorkerRequest;
use App\Http\Requests\UniversityWorkersRequest;
use App\Models\Agreement;
use App\Models\Internship;
use App\Models\University;
use App\Repositories\AgreementStatusRepository;
use App\Repositories\FacultyRepository;
use App\Repositories\RoleRepository;
use App\Repositories\UniversityRepository;
use App\Services\AgreementService;
use App\Services\CompanyService;
use App\Services\FacultyService;
use App\Services\QuestionnairesService;
use App\Services\StudentService;
use App\Services\UniversityService;
use Clockwork\Request\Log;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UniversityController extends Controller
{
    public const REQUEST_FIELD_UNIVERSITY_NAME = 'name';
    public const REQUEST_FIELD_UNIVERSITY_TYPE_ID = 'universityTypeId';
    public const REQUEST_FIELD_UNIVERSITY_CITY_ID = 'cityId';
    public const REQUEST_FIELD_UNIVERSITY_STREET = 'street';
    public const REQUEST_FIELD_UNIVERSITY_STREET_NUMBER = 'streetNumber';
    public const REQUEST_FIELD_UNIVERSITY_EMAIL = 'email';
    public const REQUEST_FIELD_UNIVERSITY_PHONE = 'phone';
    public const REQUEST_FIELD_UNIVERSITY_WEBSITE = 'website';
    public const REQUEST_FIELD_USER_ID = 'userId';

    public const REQUEST_FIELD_OWN_AGREEMENT_COMPANY_ID = 'company.id';
    public const REQUEST_FIELD_OWN_AGREEMENT_COMPANY_NAME = 'company.name';
    public const REQUEST_FIELD_OWN_AGREEMENT_COMPANY_CITY_ID = 'company.city.id';
    public const REQUEST_FIELD_OWN_AGREEMENT_COMPANY_STREET = 'company.street';
    public const REQUEST_FIELD_OWN_AGREEMENT_COMPANY_STREET_NUMBER = 'company.streetNumber';
    public const REQUEST_FIELD_OWN_AGREEMENT_COMPANY_EMAIL = 'company.email';
    public const REQUEST_FIELD_OWN_AGREEMENT_COMPANY_CATEGORY_ID = 'company.companyCategoryId';
    public const REQUEST_FIELD_OWN_AGREEMENT_COMPANY_PHONE = 'company.phone';
    public const REQUEST_FIELD_OWN_AGREEMENT_COMPANY_WEBSITE = 'company.website';
    public const REQUEST_FIELD_OWN_AGREEMENT_COMPANY_DESCRIPTION = 'company.description';
    public const REQUEST_FIELD_OWN_AGREEMENT_NAME = 'agreement.name';
    public const REQUEST_FIELD_OWN_AGREEMENT_DATE_FROM = 'agreement.dateFrom';
    public const REQUEST_FIELD_OWN_AGREEMENT_DATE_TO = 'agreement.dateTo';
    public const REQUEST_FIELD_OWN_AGREEMENT_PROGRAM = 'agreement.program';
    public const REQUEST_FIELD_OWN_AGREEMENT_SCHEDULE = 'agreement.schedule';
    public const REQUEST_FIELD_OWN_AGREEMENT_UNIVERSITY_SUPERVISOR_ID = 'agreement.universitySupervisorId';
    public const REQUEST_FIELD_OWN_AGREEMENT_PLACES_NUMBER = 'agreement.placesNumber';
    public const REQUEST_FIELD_OWN_AGREEMENT_CONTENT = 'agreement.content';
    public const REQUEST_FIELD_OWN_AGREEMENT_ACTIVE = 'agreement.active';
    public const REQUEST_FIELD_OWN_AGREEMENT_SIGNING_DATE = 'agreement.signingDate';

    public const REQUEST_FIELD_REJECT_UNIVERSITY_REASON = 'reason';
    public const REQUEST_FIELD_REJECT_STUDENT_REASON = 'reason';
    public const REQUEST_FIELD_REJECT_UNIVERSITY_WORKER_REASON = 'reason';
    public const REQUEST_FIELD_UPDATE_UNIVERSITY_DATA_EMAIL = 'email';
    public const REQUEST_FIELD_UPDATE_UNIVERSITY_DATA_WEBSITE = 'website';
    public const REQUEST_FIELD_UPDATE_UNIVERSITY_DATA_PHONE = 'phone';

    /**
     * @var UniversityRepository
     */
    private $universityRepository;

    /**
     * @var QuestionnairesService
     */
    private $questionnairesService;

    /**
     * @var FacultyService
     */
    private $facultyService;

    /**
     * @var FacultyRepository
     */
    private $facultyRepository;

    /**
     * @var UniversityService
     */
    private $universityService;

    /**
     * @var RoleRepository
     */
    private $roleRepository;

    /**
     * @var StudentService
     */
    private $studentService;

    /**
     * @var CompanyService
     */
    private $companyService;

    /**
     * @var AgreementService
     */
    private $agreementService;

    /**
     * @var AgreementStatusRepository
     */
    private $agreementStatusRepository;

    /**
     * UniversityController constructor.
     *
     * @param UniversityRepository  $universityRepository
     * @param QuestionnairesService $questionnairesService
     * @param FacultyService        $facultyService
     * @param FacultyRepository     $facultyRepository
     * @param UniversityService     $universityService
     * @param RoleRepository        $roleRepository
     */
    public function __construct(
        UniversityRepository $universityRepository,
        QuestionnairesService $questionnairesService,
        FacultyService $facultyService,
        FacultyRepository $facultyRepository,
        UniversityService $universityService,
        RoleRepository $roleRepository,
        StudentService $studentService,
        CompanyService $companyService,
        AgreementService $agreementService,
        AgreementStatusRepository $agreementStatusRepository
    ) {
        $this->universityRepository = $universityRepository;
        $this->questionnairesService = $questionnairesService;
        $this->facultyService = $facultyService;
        $this->facultyRepository = $facultyRepository;
        $this->universityService = $universityService;
        $this->roleRepository = $roleRepository;
        $this->studentService = $studentService;
        $this->companyService = $companyService;
        $this->agreementService = $agreementService;
        $this->agreementStatusRepository = $agreementStatusRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $universities = University::all();

        if (isset($universities)) {
            return response(
                [
                    'status' => 'success',
                    'data' => $universities,
                    'message' => null,
                ],
                Response::HTTP_OK
            );
        } else {
            return \response(
                [
                    'status' => 'error',
                    'data' => null,
                    'message' => 'Nie znaleziono żadnego uniwersytetu!',
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Return specific university faculties
     *
     * @param $id
     *
     * @return Response
     */
    public function universityFaculties($id)
    {
        $universities = University::find($id);

        if (isset($universities->faculties)) {
            return response(
                [
                    'status' => 'success',
                    'data' => $universities->faculties,
                    'message' => null,
                ],
                Response::HTTP_OK
            );
        } else {
            return \response(
                [
                    'status' => 'error',
                    'data' => null,
                    'message' => 'Nie znaleziono żadnego uniwersytetu!',
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
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
        $validatedData = $request->validate(
            [
                'name' => 'required|unique:universities|max:255',
                'universityTypeId' => 'required',
                'cityId' => 'required',
                'street' => 'required|max:64',
                'streetNumber' => 'required|max:8',
                'email' => 'required|max:64',
                'phone' => 'required|max:16',
                'website' => 'required|max:64',
            ],
            University::messages()
        );

        $university = new University;

        $university->name = $request->input('name');
        $university->university_type_id = $request->input('universityTypeId');
        $university->city_id = $request->input('cityId');
        $university->street = $request->input('street');
        $university->street_number = $request->input('streetNumber');
        $university->email = $request->input('email');
        $university->phone = $request->input('phone');
        $university->website = $request->input('website');
        $university->access_code = $this->generateUniqueRandomAccessCode();
        $university->created_at = date('Y-m-d H:i:s');
        $university->updated_at = date('Y-m-d H:i:s');

        if ($university->save()) {
            if ($university->users()->save(auth()->user(), ['created_at' => date('Y-m-d H:i:s')])) {
                auth()->user()->attachRole('university-worker');

                return response(
                    [
                        'status' => 'success',
                        'data' => null,
                        'message' => 'Uczelnia została dodana!',
                    ],
                    Response::HTTP_OK
                );
            }
        } else {
            return response(
                [
                    'status' => 'error',
                    'data' => null,
                    'message' => 'Niestety nie udało się dodać twojej uczelni!',
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function createUniversity(UniversityCreateUniversityRequest $request)
    {
        DB::beginTransaction();
        $createdUniversity = $this->universityService->createUniversity(
            $request->input(self::REQUEST_FIELD_UNIVERSITY_NAME),
            $request->input(self::REQUEST_FIELD_UNIVERSITY_TYPE_ID),
            $request->input(self::REQUEST_FIELD_UNIVERSITY_CITY_ID),
            $request->input(self::REQUEST_FIELD_UNIVERSITY_STREET),
            $request->input(self::REQUEST_FIELD_UNIVERSITY_STREET_NUMBER),
            $request->input(self::REQUEST_FIELD_UNIVERSITY_EMAIL),
            $request->input(self::REQUEST_FIELD_UNIVERSITY_PHONE),
            $request->input(self::REQUEST_FIELD_UNIVERSITY_WEBSITE)
        );

        if (!is_null($createdUniversity)) {
            $result = $this->universityService->addUserToUniversityWithRole(
                !empty($request->input(self::REQUEST_FIELD_USER_ID)) ?
                    $request->input(self::REQUEST_FIELD_USER_ID) : Auth::id(),
                $createdUniversity->id,
                $this->roleRepository->getRoleByName(RoleConstants::ROLE_UNIVERSITY_OWNER)->id,
                true,
                true
            );

            if (!is_null($result)) {
                DB::commit();
                return response($createdUniversity, Response::HTTP_CREATED);
            }
        }

        DB::rollBack();
        return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Display the specified resource.
     *
     * @param UniversityGetUniversityRequest $request
     * @param string                         $slug
     *
     * @return Response
     */
    public function getUniversity(UniversityGetUniversityRequest $request, string $slug): Response
    {
        $university = $this->universityRepository->getUniversityBySlug($slug);

        if ($university !== null) {
            return response($university, Response::HTTP_OK);
        }

        return response(null, Response::HTTP_NOT_FOUND);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param University $university
     *
     * @return Response
     */
    public function edit(University $university)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request    $request
     * @param University $university
     *
     * @return Response
     */
    public function update(Request $request, University $university)
    {
        //TODO: Create method to update University
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
        $university = University::find($id);

        if ($university->delete()) {
            return response("University has been deleted!", Response::HTTP_OK);
        } else {
            return response("University has not been deleted", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Set new access code for university.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function setNewAccessCode(Request $request)
    {
        $university = University::find($request->input("id"));

        if (isset($university)) {
            $university->access_code = $this->generateUniqueRandomAccessCode();

            if ($university->save()) {
                return response(
                    [
                        'status' => 'success',
                        'data' => $university->access_code,
                        'message' => null,
                    ],
                    Response::HTTP_OK
                );
            }
        }

        return response(
            [
                'status' => 'error',
                'data' => null,
                'message' => 'New access code has been not generate!',
            ],
            Response::HTTP_NOT_MODIFIED
        );
    }

    /**
     * Use access code to join to university
     *
     * @param Request $request
     *
     * @return Response
     */
    public function useCode(Request $request)
    {
        $university = University::where('access_code', $request->input('accessCode'))->first();
        $errorMessage = "Coś poszło nie tak!";

        if ($university === null) {
            $errorMessage = "Nie udało się dopasować podanego kodu do żadnej uczelni!";
        } else {
            if ((count($university->users()->where('user_id', auth()->id())->get()) < 1)) {
                if ($university->users()->save(auth()->user(), ['created_at' => date('Y-m-d H:i:s')])) {
                    auth()->user()->attachRole('university-worker');
                    return response(
                        [
                            'status' => 'success',
                            'data' => $university,
                            'message' => null,
                        ],
                        Response::HTTP_OK
                    );
                } else {
                    $errorMessage = "Nie udało się dodać Cię do tej uczelni!";
                }
            } else {
                $errorMessage = 'Należysz już do uczelni do której przypisano podany kod!';
            }
        }

        return response(
            [
                'status' => 'error',
                'data' => null,
                'message' => $errorMessage,
            ],
            Response::HTTP_INTERNAL_SERVER_ERROR
        );
    }

    /**
     * Use access code to join to university
     *
     * @param $id
     *
     * @return Response
     */
    public function getUsers($id)
    {
        $university = University::find($id);

        if (isset($university)) {
            return response(
                [
                    'status' => 'success',
                    'data' => $university->users,
                    'message' => null,
                ],
                Response::HTTP_OK
            );
        } else {
            return response(
                [
                    'status' => 'error',
                    'data' => null,
                    'message' => "Nie udało się znaleźć użytkowników tej uczelni",
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Return university agreements
     *
     * @param $id
     *
     * @return Response
     */
    public function getUniversityAgreements($id)
    {
        $university = Agreement::with(['offer', 'company'])->where(['university_id' => $id])->get();

        if (isset($university)) {
            return response(
                [
                    'status' => 'success',
                    'data' => $university,
                    'message' => null,
                ],
                Response::HTTP_OK
            );
        } else {
            return response(
                [
                    'status' => 'error',
                    'data' => null,
                    'message' => "Nie udało się żadnych umów dla tej uczelni!",
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Return university internhips
     *
     * @param $id
     *
     * @return Response
     */
    public function getInternships($id)
    {
        $agreements = Agreement::where(['university_id' => $id])->get();
        $internships = Internship::with(
            [
                'offer',
                'student.user',
                'university_supervisor',
                'company_supervisor',
                'student.internships.offer',
                'student.internships.agreement',
            ]
        )->whereIn('agreement_id', Arr::pluck($agreements->toArray(), 'id'))->get();

        if (count($internships) > -1) {
            return response(
                [
                    'status' => 'success',
                    'data' => $internships,
                    'message' => null,
                ],
                Response::HTTP_OK
            );
        } else {
            return response(
                [
                    'status' => 'error',
                    'data' => null,
                    'message' => "Nie udało się żadnych praktyk dla tej uczelni!",
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * @param UniversityWorkersRequest $request
     * @param string                   $slug
     *
     * @return Response
     */
    public function getWorkers(UniversityWorkersRequest $request, string $slug): Response
    {
        $workers = $this->universityRepository->getWorkers($slug);

        if (!is_null($workers)) {
            return \response($workers, Response::HTTP_OK);
        }

        return \response(null, Response::HTTP_NOT_FOUND);
    }

    /**
     * @param UniversityStudentsRequest $request
     * @param string                    $slug
     *
     * @return Response
     */
    public function getStudents(UniversityStudentsRequest $request, string $slug): Response
    {
        $students = $this->universityRepository->getStudents($slug);

        if (!is_null($students)) {
            return \response($students, Response::HTTP_OK);
        }

        return \response(null, Response::HTTP_NOT_FOUND);
    }

    public function getAgreements(UniversityAgreementsRequest $request, string $slug): Response
    {
        $agreements = $this->universityRepository->getAgreements($slug);

        if (!is_null($agreements)) {
            return \response($agreements, Response::HTTP_OK);
        }

        return \response(null, Response::HTTP_NOT_FOUND);
    }

    public function getInternships2(UniversityInternshipsRequest $request, string $slug): Response
    {
        $internships = $this->universityRepository->getInternships($slug);

        if (!is_null($internships)) {
            return \response($internships, Response::HTTP_OK);
        }

        return \response(null, Response::HTTP_NOT_FOUND);
    }

    public function getOffers(UniversityInternshipsRequest $request, string $slug): Response
    {
        $offers = $this->universityRepository->getOffers($slug);

        if (!is_null($offers)) {
            return \response($offers, Response::HTTP_OK);
        }

        return \response(null, Response::HTTP_NOT_FOUND);
    }

    public function getFaculties(UniversityInternshipsRequest $request, string $slug): Response
    {
        $faculties = $this->universityRepository->getFaculties($slug);

        if (!is_null($faculties)) {
            return \response($faculties, Response::HTTP_OK);
        }

        return \response(null, Response::HTTP_NOT_FOUND);
    }

    public function getUniversityQuestionnaires(
        UniversityGetUniversityQuestionnairesRequest $request,
        string $slug
    ): Response {
        $questionnaires = $this->universityRepository->getQuestionnaires($slug);

        if (!is_null($questionnaires)) {
            return response($questionnaires, Response::HTTP_OK);
        }

        return response(null, Response::HTTP_NOT_FOUND);
    }

    public function createUniversityQuestionnaire(
        UniversityCreateUniversityQuestionnaireRequest $request,
        string $slug
    ): Response {
        $university = $this->universityRepository->getUniversityBySlug($slug);

        if ($university !== null) {
            $questionnaire = $this->questionnairesService->createQuestionnaire(
                $request->input('name'),
                $request->input('description'),
                null,
                $university->id
            );

            if ($questionnaire !== null) {
                return response($questionnaire, Response::HTTP_CREATED);
            }
        }

        return \response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * @param UpdateLogoRequest $request
     * @param string            $slug
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response
     */
    public function updateUniversityLogo(UpdateLogoRequest $request, string $slug)
    {
        $path = $request->file('logo')->store('logos');

        if (!empty($path)) {
            $university = $this->universityRepository->getUniversityBySlug($slug);
            if ($university !== null) {
                $oldAvatarPath = $university->logo_url;

                $university->logo_url = $path;

                if ($university->update()) {
                    if (!empty($oldAvatarPath)) {
                        Storage::delete($oldAvatarPath);
                    }

                    return response($path, Response::HTTP_OK);
                }
            }
        }

        return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function createUniversityFaculty(CreateFacultyRequest $request, string $slug)
    {
        $university = $this->universityRepository->getUniversityBySlug($slug);
        $faculty = $this->facultyService->createFaculty($request->input('name'), $university->id);

        if ($faculty !== null) {
            return response($faculty, Response::HTTP_CREATED);
        }

        return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function createUniversityFacultyField(CreateFieldRequest $request, string $slug, int $facultyId)
    {
        $field = $this->facultyService->createFacultyField($request->input('name'), $facultyId);

        if ($field !== null) {
            return response($field, Response::HTTP_CREATED);
        }

        return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function createUniversityFacultyFieldSpecialization(
        CreateSpecializationRequest $request,
        string $slug,
        int $facultyId,
        int $fieldId
    ) {
        $specialization = $this->facultyService->createFieldSpecialization($request->input('name'), $fieldId);

        if ($specialization !== null) {
            return response($specialization, Response::HTTP_CREATED);
        }

        return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function updateUniversityFaculty(
        UniversityUpdateUniversityFacultyRequest $request,
        string $slug,
        int $facultyId
    ) {
        $faculty = $this->facultyService->updateFaculty($request->input('name'), $facultyId);

        if ($faculty !== null) {
            return response($faculty, Response::HTTP_CREATED);
        }

        return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function updateUniversityFacultyField(
        UniversityUpdateUniversityFacultyFieldRequest $request,
        string $slug,
        int $facultyId,
        int $fieldId
    ) {
        $field = $this->facultyService->updateFacultyField($request->input('name'), $fieldId);

        if ($field !== null) {
            return response($field, Response::HTTP_CREATED);
        }

        return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function updateUniversityFacultyFieldSpecialization(
        UniversityUpdateUniversityFacultyFieldSpecializationRequest $request,
        string $slug,
        int $facultyId,
        int $fieldId,
        int $specializationId
    ) {
        $specialization = $this->facultyService->updateFieldSpecialization($request->input('name'), $specializationId);

        if ($specialization !== null) {
            return response($specialization, Response::HTTP_CREATED);
        }

        return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function deleteUniversityFaculty(
        UniversityUpdateUniversityFacultyRequest $request,
        string $slug,
        int $facultyId
    ) {
        $isFacultyDeleted = $this->facultyService->deleteFaculty($facultyId);

        if ($isFacultyDeleted) {
            return response(null, Response::HTTP_CREATED);
        }

        return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function deleteUniversityFacultyField(
        UniversityUpdateUniversityFacultyFieldRequest $request,
        string $slug,
        int $facultyId,
        int $fieldId
    ) {
        $isFieldDeleted = $this->facultyService->deleteFacultyField($fieldId);

        if ($isFieldDeleted) {
            return response(null, Response::HTTP_CREATED);
        }

        return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function deleteUniversityFacultyFieldSpecialization(
        UniversityUpdateUniversityFacultyFieldSpecializationRequest $request,
        string $slug,
        int $facultyId,
        int $fieldId,
        int $specializationId
    ) {
        $isSpecializationDeleted = $this->facultyService->deleteFieldSpecialization($specializationId);

        if ($isSpecializationDeleted) {
            return response(null, Response::HTTP_CREATED);
        }

        return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function changeUniversityWorkerRoles(
        UniversityChangeUniversityWorkerRolesRequest $request,
        string $slug,
        int $userId
    ) {
        try {
            $this->universityService->changeUniversityWorkerRoles(
                $request->input('userUniversityId'),
                $request->input('rolesIds')
            );

            return response(null, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function verifyUniversityWorker(UniversityVerifyUniversityWorkerRequest $request, string $slug, int $userId)
    {
        $universityWorker = $this->universityService->verifyUniversityWorker($slug, $userId);
        $university = $this->universityRepository->getUniversityBySlug($slug);

        if (!is_null($university) && !is_null($universityWorker)) {
            UniversityWorkerVerified::dispatch(
                $university,
                $universityWorker,
            );

            return response($universityWorker, Response::HTTP_OK);
        }

        return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function rejectUniversityWorker(UniversityRejectUniversityWorkerRequest $request, string $slug, int $userId)
    {
        $universityWorker = $this->universityService->rejectUniversityWorker($slug, $userId);
        $university = $this->universityRepository->getUniversityBySlug($slug);

        if (!is_null($universityWorker) && !is_null($university)) {
            UniversityWorkerRejected::dispatch(
                $university,
                $universityWorker,
                $request->input(self::REQUEST_FIELD_REJECT_UNIVERSITY_WORKER_REASON)
            );
            return response($universityWorker, Response::HTTP_OK);
        }

        return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function getUniversities()
    {
        $universities = $this->universityRepository->getUniversities();

        return response($universities, Response::HTTP_OK);
    }

    public function addWorkerToUniversity(
        UniversityAddWorkerToUniversityRequest $request,
        string $slug,
        int $userId = null
    ) {
        $university = $this->universityRepository->getUniversityBySlug($slug);

        DB::beginTransaction();
        if (!is_null($university)) {
            $userUniversity = $this->universityService->addUserToUniversityWithRole(
                $userId ?? Auth::id(),
                $university->id,
                $this->roleRepository->getRoleByName(RoleConstants::ROLE_UNIVERSITY_WORKER)->id
            );

            if (!is_null($userUniversity)) {
                \Illuminate\Support\Facades\Log::channel(config('global.defaultLogChannel'))->info(
                    'Dodano użytkownika do uczelni',
                    [
                        'userId' => Auth::id(),
                        'data' => [
                            'universitySlug' => $slug,
                            'userId' => $userId,
                        ],
                    ]
                );

                DB::commit();
                return response($userUniversity, Response::HTTP_OK);
            }
        }

        \Illuminate\Support\Facades\Log::channel(config('global.defaultLogChannel'))->error(
            'Nie udało się dodać użytkownika do uczelni',
            [
                'userId' => Auth::id(),
                'data' => [
                    'universitySlug' => $slug,
                    'userId' => $userId,
                ],
            ]
        );

        DB::rollBack();
        return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function addStudentToUniversity(
        UniversityAddStudentToUniversityRequest $request,
        string $slug,
        int $userId = null
    ) {
        $university = $this->universityRepository->getUniversityBySlug($slug);

        DB::beginTransaction();
        if (!is_null($university)) {
            $userUniversity = $this->universityService->addUserToUniversityWithRole(
                $userId ?? Auth::id(),
                $university->id,
                $this->roleRepository->getRoleByName(RoleConstants::ROLE_STUDENT)->id
            );

            $student = $this->studentService->createStudent(
                $userId ?? Auth::id(),
                $request->input('index'),
                $request->input('semester'),
                floor($request->input('semester') / 2),
                $request->input('specializationId')
            );

            if (!is_null($userUniversity) && !is_null($student)) {
                DB::commit();
                return response($userUniversity, Response::HTTP_OK);
            }
        }

        DB::rollBack();
        return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
    }


    /**
     * @param UniversityCreateOwnAgreementRequest $request
     * @param string                              $slug
     *
     * @return Response
     */
    public function createOwnAgreement(UniversityCreateOwnAgreementRequest $request, string $slug): Response
    {
        $university = $this->universityRepository->getUniversityBySlug($slug);

        DB::beginTransaction();
        if (!is_null($university)) {
            $companyId = $request->input(self::REQUEST_FIELD_OWN_AGREEMENT_COMPANY_ID);
            $isExistingCompany = !is_null($request->input(self::REQUEST_FIELD_OWN_AGREEMENT_COMPANY_ID));

            if (empty($companyId)) {
                $company = $this->companyService->createCompany(
                    $request->input(self::REQUEST_FIELD_OWN_AGREEMENT_COMPANY_NAME),
                    $request->input(self::REQUEST_FIELD_OWN_AGREEMENT_COMPANY_CITY_ID),
                    $request->input(self::REQUEST_FIELD_OWN_AGREEMENT_COMPANY_STREET),
                    $request->input(self::REQUEST_FIELD_OWN_AGREEMENT_COMPANY_STREET_NUMBER),
                    $request->input(self::REQUEST_FIELD_OWN_AGREEMENT_COMPANY_EMAIL),
                    $request->input(self::REQUEST_FIELD_OWN_AGREEMENT_COMPANY_CATEGORY_ID),
                    $request->input(self::REQUEST_FIELD_OWN_AGREEMENT_COMPANY_PHONE),
                    $request->input(self::REQUEST_FIELD_OWN_AGREEMENT_COMPANY_WEBSITE),
                    $request->input(self::REQUEST_FIELD_OWN_AGREEMENT_COMPANY_DESCRIPTION),
                    null,
                    Auth::id(),
                    true,
                );

                $companyId = $company->id ?? null;
            }

            if (!empty($companyId)) {
                $agreement = $this->agreementService->createAgreement(
                    $request->input(self::REQUEST_FIELD_OWN_AGREEMENT_NAME),
                    $request->input(self::REQUEST_FIELD_OWN_AGREEMENT_DATE_FROM),
                    $request->input(self::REQUEST_FIELD_OWN_AGREEMENT_DATE_TO),
                    $request->input(self::REQUEST_FIELD_OWN_AGREEMENT_PROGRAM),
                    $companyId,
                    $university->id,
                    $request->input(self::REQUEST_FIELD_OWN_AGREEMENT_UNIVERSITY_SUPERVISOR_ID),
                    $request->input(self::REQUEST_FIELD_OWN_AGREEMENT_PLACES_NUMBER),
                    $request->input(self::REQUEST_FIELD_OWN_AGREEMENT_SCHEDULE),
                    $request->input(self::REQUEST_FIELD_OWN_AGREEMENT_CONTENT),
                    null,
                    $request->input(self::REQUEST_FIELD_OWN_AGREEMENT_ACTIVE),
                    $request->input(self::REQUEST_FIELD_OWN_AGREEMENT_SIGNING_DATE),
                    $this->agreementStatusRepository
                        ->getStatusByName(
                            $isExistingCompany ?
                                AgreementStatusConstants::STATUS_NEW :
                                AgreementStatusConstants::STATUS_ACCEPTED
                        )->id
                );

                if (!is_null($agreement)) {
                    DB::commit();
                    return response($agreement, Response::HTTP_CREATED);
                }
            }
        }

        DB::rollBack();
        return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function getUniversitiesToVerification(UniversityGetUniversitiesToVerificationRequest $request)
    {
        return response($this->universityRepository->getUniversitiesToVerification(), Response::HTTP_OK);
    }

    /**
     * @param UniversityVerifyUniversityRequest $request
     * @param string                            $slug
     *
     * @return Response
     */
    public function verifyUniversity(UniversityVerifyUniversityRequest $request, string $slug): Response
    {
        $verifiedUniversity = $this->universityService->verifyUniversity($slug);

        if (!is_null($verifiedUniversity)) {
            UniversityVerified::dispatch(
                $verifiedUniversity->user,
                $verifiedUniversity
            );
            return response($verifiedUniversity, Response::HTTP_OK);
        }

        return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * @param UniversityRejectUniversityRequest $request
     * @param string                            $slug
     *
     * @return Response
     */
    public function rejectUniversity(UniversityRejectUniversityRequest $request, string $slug): Response
    {
        $rejectedUniversity = $this->universityService->rejectUniversity($slug);

        if (!is_null($rejectedUniversity)) {
            UniversityRejected::dispatch(
                $rejectedUniversity->user,
                $rejectedUniversity,
                $request->input(self::REQUEST_FIELD_REJECT_UNIVERSITY_REASON)
            );
            return response($rejectedUniversity, Response::HTTP_OK);
        }

        return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function verifyStudentInUniversity(
        UniversityVerifyStudentInUniversityRequest $request,
        string $slug,
        int $userId
    ) {
        $verifiedStudent = $this->universityService->verifyStudentInUniversity($slug, $userId);
        $university = $this->universityRepository->getUniversityBySlug($slug);

        if (!is_null($verifiedStudent) && !is_null($university)) {
            StudentVerified::dispatch(
                $verifiedStudent,
                $university
            );
            return response($verifiedStudent, Response::HTTP_OK);
        }

        return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function rejectStudentInUniversity(
        UniversityRejectStudentInUniversityRequest $request,
        string $slug,
        int $userId
    ) {
        $rejectedStudent = $this->universityService->rejectStudentInUniversity($slug, $userId);
        $university = $this->universityRepository->getUniversityBySlug($slug);

        if (!is_null($rejectedStudent) && !is_null($university)) {
            StudentRejected::dispatch(
                $rejectedStudent,
                $university,
                $request->input(self::REQUEST_FIELD_REJECT_UNIVERSITY_REASON)
            );
            return response($rejectedStudent, Response::HTTP_OK);
        }

        return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function getUniversityOffers(UniversityGetUniversityOffersRequest $request, string $slug)
    {
        return response($this->universityRepository->getUniversityOffers($slug), Response::HTTP_OK);
    }

    public function updateUniversityData(UniversityUpdateUniversityDataRequest $request, string $slug)
    {
        $updatedUniversity = $this->universityService->updateUniversityData(
            $slug,
            $request->input(self::REQUEST_FIELD_UPDATE_UNIVERSITY_DATA_EMAIL),
            $request->input(self::REQUEST_FIELD_UPDATE_UNIVERSITY_DATA_WEBSITE),
            $request->input(self::REQUEST_FIELD_UPDATE_UNIVERSITY_DATA_PHONE),
        );

        if (!is_null($updatedUniversity)) {
            return response($updatedUniversity, Response::HTTP_OK);
        }

        return \response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Generate unique random access code.
     *
     * @return string
     */
    private function generateUniqueRandomAccessCode()
    {
        do {
            $randomAccessCode = Str::upper(Str::random(8));
        } while (count(University::where('access_code', $randomAccessCode)->get()) > 0);

        return $randomAccessCode;
    }
}
