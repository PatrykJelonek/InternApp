<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentJournalEntryCreateJournalEntryCommentRequest;
use App\Http\Requests\StudentJournalEntryCreateJournalEntryRequest;
use App\Http\Requests\StudentJournalEntryGetStudentJournalEntryCommentsRequest;
use App\Http\Resources\Collections\JournalEntryCollection;
use App\Http\Resources\JournalEntryResource;
use App\Repositories\InternshipRepository;
use App\Repositories\JournalRepository;
use App\Repositories\StudentRepository;
use App\Services\JournalService;
use Illuminate\Http\Request;
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
                $student = $this->internshipRepository->getInternshipStudentByIndex($internshipId, $studentIndex);
                $studentId = $student->id ?? null;

                if (!empty($studentId)) {
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

    public function getStudentJournalEntryComments(
        StudentJournalEntryGetStudentJournalEntryCommentsRequest $request,
        int $internshipId,
        string $studentIndex,
        int $studentJournalEntryId
    ) {
        return response($this->journalRepository->getStudentJournalEntryComments($studentJournalEntryId), Response::HTTP_OK);
    }
}
