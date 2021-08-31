<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentJournalEntryDeleteStudentJournalEntryCommentRequest;
use App\Http\Requests\StudentJournalEntryCreateJournalEntryCommentRequest;
use App\Http\Requests\StudentJournalEntryCreateJournalEntryRequest;
use App\Http\Requests\StudentJournalEntryDeleteStudentJournalEntryRequest;
use App\Http\Requests\StudentJournalEntryGetStudentJournalEntryCommentsRequest;
use App\Http\Requests\StudentJournalEntryUpdateStudentJournalEntryRequest;
use App\Repositories\InternshipRepository;
use App\Repositories\JournalRepository;
use App\Repositories\StudentRepository;
use App\Services\JournalService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentJournalEntryController extends Controller
{
    protected const REQUEST_FIELD_JOURNAL_ENTRY_CONTENT = 'content';
    protected const REQUEST_FIELD_JOURNAL_ENTRY_STUDENT_IDS = 'students_ids';
    protected const REQUEST_FIELD_JOURNAL_ENTRY_DATE = 'date';
    protected const REQUEST_FIELD_JOURNAL_ENTRY_ACCEPTED = 'accepted';
    protected const JOURNAL_ENTRY_ACCEPTED = true;
    protected const JOURNAL_ENTRY_NOT_ACCEPTED = false;

    protected const REQUEST_FIELD_JOURNAL_ENTRY_COMMENT_CONTENT = 'content';
    protected const REQUEST_FIELD_JOURNAL_ENTRY_COMMENT_STUDENT_IDS = 'students_ids';

    /**
     * @var StudentRepository
     */
    private $studentRepository;

    /**
     * @var JournalService
     */
    private $journalService;

    /**
     * @var InternshipRepository
     */
    private $internshipRepository;

    /**
     * @var JournalRepository
     */
    private $journalRepository;

    /**
     * StudentJournalEntryController constructor.
     *
     * @param StudentRepository    $studentRepository
     * @param JournalService       $journalService
     * @param InternshipRepository $internshipRepository
     * @param JournalRepository    $journalRepository
     */
    public function __construct(
        StudentRepository $studentRepository,
        JournalService $journalService,
        InternshipRepository $internshipRepository,
        JournalRepository $journalRepository
    ) {
        $this->studentRepository = $studentRepository;
        $this->journalService = $journalService;
        $this->internshipRepository = $internshipRepository;
        $this->journalRepository = $journalRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param int $internshipId
     * @param int $studentIndex
     *
     * @return \Illuminate\Http\Response
     */
    public function index(int $internshipId, int $studentIndex)
    {
        $studentJournalEntries = $this->studentRepository->getStudentJournalEntries($internshipId, $studentIndex);

        if (!empty($studentJournalEntries)) {
            return response($studentJournalEntries, Response::HTTP_OK);
        }

        response(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param int                                          $internshipId
     * @param string                                       $studentIndex
     * @param StudentJournalEntryCreateJournalEntryRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function createJournalEntry(
        StudentJournalEntryCreateJournalEntryRequest $request,
        int $internshipId,
        string $studentIndex
    ): Response {
        DB::beginTransaction();
        $journalEntry = $this->journalService->createJournalEntry(
            $internshipId,
            $request->input(self::REQUEST_FIELD_JOURNAL_ENTRY_CONTENT),
            $request->input(self::REQUEST_FIELD_JOURNAL_ENTRY_DATE),
            $request->input(self::REQUEST_FIELD_JOURNAL_ENTRY_ACCEPTED),
            Auth::id(),
        );

        if (!is_null($journalEntry)) {
            $studentIds = $request->input(self::REQUEST_FIELD_JOURNAL_ENTRY_STUDENT_IDS);

            if (!empty($studentIds)) {
                foreach ($studentIds as $studentId) {
                    $journalEntry->students()->attach($studentId, [
                        'accepted' => self::JOURNAL_ENTRY_ACCEPTED,
                    ]);
                }
            } else {
                $internshipStudent = $this->internshipRepository->getInternshipStudentByIndex($internshipId, $studentIndex);
                $studentId = $internshipStudent->student->id ?? null;

                if (empty($studentId)) {
                    $student = $this->studentRepository->getStudentByUserId(Auth::id());
                    $studentId = $student->id;
                }

                $journalEntry->students()->attach($studentId, [
                    'accepted' => self::JOURNAL_ENTRY_NOT_ACCEPTED,
                ]);
            }

            DB::commit();
            return response($journalEntry, Response::HTTP_CREATED);
        }

        DB::rollBack();
        return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function createJournalEntryComment(
        StudentJournalEntryCreateJournalEntryCommentRequest $request,
        int $internshipId,
        string $studentIndex,
        int $studentJournalEntryId
    ) {
        DB::beginTransaction();
        $comment = $this->journalService->createComment(
            $request->input(self::REQUEST_FIELD_JOURNAL_ENTRY_COMMENT_CONTENT),
            Auth::id(),
        );

        if (!is_null($comment)) {
            $studentJournalEntry = $this->journalRepository->getStudentJournalEntryById($studentJournalEntryId);

            if (!empty($studentJournalEntry)) {
                $studentJournalEntry->comments()->attach($comment->id);
            }

            DB::commit();
            return response($comment, Response::HTTP_CREATED);
        }

        DB::rollBack();
        return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function getStudentJournalEntryComments(
        StudentJournalEntryGetStudentJournalEntryCommentsRequest $request,
        int $internshipId,
        string $studentIndex,
        int $studentJournalEntryId
    ) {
        return response(
            $this->journalRepository->getStudentJournalEntryComments($studentJournalEntryId),
            Response::HTTP_OK
        );
    }

    public function updateStudentJournalEntry(
        StudentJournalEntryDeleteStudentJournalEntryRequest $request,
        int $internshipId,
        string $studentIndex,
        int $studentJournalEntryId
    ) {
        $studentJournalEntry = $this->journalService->updateStudentJournalEntry(
            $studentJournalEntryId,
            $request->input(self::REQUEST_FIELD_JOURNAL_ENTRY_CONTENT),
            $request->input(self::REQUEST_FIELD_JOURNAL_ENTRY_DATE)
        );

        if (!is_null($studentJournalEntry)) {
            return response($studentJournalEntry, Response::HTTP_OK);
        }

        return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function deleteStudentJournalEntry(
        StudentJournalEntryUpdateStudentJournalEntryRequest $request,
        int $internshipId,
        string $studentIndex,
        int $studentJournalEntryId
    ) {
        return response($this->journalService->deleteStudentJournalEntry($studentJournalEntryId));
    }

    public function deleteStudentJournalEntryComment(
        StudentJournalEntryDeleteStudentJournalEntryCommentRequest $request,
        int $internshipId,
        string $studentIndex,
        int $studentJournalEntryId,
        int $commentId
    ) {
        return response($this->journalService->deleteComment($commentId));
    }
}
