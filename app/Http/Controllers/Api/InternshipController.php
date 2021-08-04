<?php

namespace App\Http\Controllers\Api;

use App\Constants\InternshipStatusConstants;
use App\Http\Controllers\Controller;
use App\Http\Requests\InternshipChangeInternshipStatusRequest;
use App\Http\Requests\InternshipDownloadInternshipJournalRequest;
use App\Http\Requests\InternshipGetInternshipStudentRequest;
use App\Http\Requests\InternshipSetInternshipStudentGradeRequest;
use App\Http\Requests\InternshipStatusesRequest;
use App\Http\Requests\InternshipStoreRequest;
use App\Http\Requests\InternshipSummarizeInternshipRequest;
use App\Http\Resources\InternshipResource;
use App\Models\Agreement;
use App\Models\Internship;
use App\Models\InternshipStatus;
use App\Models\User;
use App\Repositories\InternshipRepository;
use App\Repositories\StudentRepository;
use App\Repositories\UserRepository;
use App\Services\InternshipService;
use App\Services\StudentService;
use Illuminate\Support\Facades\DB;
use \PDF;
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
     * @var InternshipService
     */
    private $internshipService;

    /**
     * @var PDF
     */
    private $pdfCreator;

    /**
     * @var StudentRepository
     */
    private $studentRepository;

    /**
     * @var StudentService
     */
    private $studentService;

    /**
     * InternshipController constructor.
     *
     * @param InternshipRepository $internshipRepository
     * @param UserRepository       $userRepository
     * @param InternshipService    $internshipService
     * @param StudentRepository    $studentRepository
     * @param StudentService       $studentService
     */
    public function __construct(
        InternshipRepository $internshipRepository,
        UserRepository $userRepository,
        InternshipService $internshipService,
        StudentRepository $studentRepository,
        StudentService $studentService
    ) {
        $this->internshipRepository = $internshipRepository;
        $this->userRepository = $userRepository;
        $this->internshipService = $internshipService;
        $this->studentRepository = $studentRepository;
        $this->studentService = $studentService;
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
     * @param InternshipStoreRequest $request
     *
     * @return Response
     */
    public function store(InternshipStoreRequest $request)
    {
        $data = array_merge(['userId' => Auth::user()->id], $request->all());

        $internship = $this->internshipService->applyToInternship($data);

        if ($internship !== null) {
            return response($internship, Response::HTTP_OK);
        }

        return response(null, Response::HTTP_NOT_FOUND);
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
        $internship = $this->internshipRepository->getInternship($id);

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

    public function getInternshipStatuses(InternshipStatusesRequest $request)
    {
        $statuses = $this->internshipRepository->getInternshipStatuses();
        return response($statuses, Response::HTTP_OK);
    }

    public function changeInternshipStatus(InternshipChangeInternshipStatusRequest $request, int $id)
    {
        $result = $this->internshipService->changeInternshipStatus($id, $request->input('statusId'));

        if ($result !== null) {
            return response($result, Response::HTTP_OK);
        }

        return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function preview()
    {
        return view('pdf.student_journal_pdf');
    }

    public function downloadInternshipJournal(
        InternshipDownloadInternshipJournalRequest $request,
        int $internshipId,
        string $studentIndex
    ) {
        $studentJournal = $this->studentRepository->getStudentJournalEntries($internshipId, $studentIndex);
        $internship = $this->internshipRepository->getInternship($internshipId);
        $student = $this->studentRepository->getStudentByIndex($studentIndex);
        $internshipStudent = $this->internshipRepository->getInternshipStudentByIndex($internshipId, $studentIndex);

        $pdf = PDF::loadView(
            'pdf.student_journal_pdf',
            [
                'journalEntires' => $studentJournal,
                'internship' => $internship,
                'student' => $student,
                'internshipStudent' => $internshipStudent,
            ]
        );

        return base64_encode($pdf->output());
    }

    public function summarizeInternship(InternshipSummarizeInternshipRequest $request, int $internshipId)
    {
        $opinions = $request->input('opinions');
        $summarizeSuccess = false;

        DB::beginTransaction();
        foreach ($opinions as $opinion) {
            $internshipStudent = $this->internshipRepository->getInternshipStudentByIndex(
                $internshipId,
                $opinion['index']
            );

            if (!is_null($internshipStudent)) {
                $student = $this->studentService->addCompanySupervisorOpinion(
                    $internshipStudent->id,
                    $opinion['opinion']
                );

                if (!is_null($student)) {
                    $summarizeSuccess = true;
                    continue;
                }
            }

            $summarizeSuccess = false;
        }

        if ($summarizeSuccess) {
            $internship = $this->internshipService->changeInternshipStatus(
                $internshipId,
                $this->internshipRepository->getInternshipStatusByName(
                    InternshipStatusConstants::STATUS_ENDED_BY_COMPANY
                )->id,
            );

            if (!is_null($internship)) {
                DB::commit();
                return response($internship, Response::HTTP_OK);
            }
        }

        DB::rollBack();
        return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function getInternshipStudent(
        InternshipGetInternshipStudentRequest $request,
        int $internshipId,
        string $studentIndex
    ) {
        $student = $this->internshipRepository->getInternshipStudentByIndex($internshipId, $studentIndex);

        if (!is_null($student)) {
            return response($student, Response::HTTP_OK);
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function setInternshipStudentGrade(
        InternshipSetInternshipStudentGradeRequest $request,
        int $internshipId,
        string $studentIndex
    ) {
        $internshipStudentId = $this->internshipRepository->getInternshipStudentByIndex($internshipId, $studentIndex)->id;
        $student = $this->studentService->addGrade($internshipStudentId, $request->input('grade'));

        if (!is_null($student)) {
            return response($student, Response::HTTP_OK);
        }

        return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
