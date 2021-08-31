<?php
/**
 * Created by PhpStorm.
 * User: Patryk Jelonek (patryk)
 * Date: 30/08/2021
 * Time: 19:48
 */

namespace App\Services;

use App\Models\Comment;
use App\Models\JournalEntry;
use App\Models\StudentJournalEntry;
use App\Models\Task;
use App\Repositories\JournalRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class JournalService
{
    /**
     * @var JournalRepository
     */
    private $journalRepository;

    /**
     * @param JournalRepository $journalRepository
     */
    public function __construct(JournalRepository $journalRepository)
    {
        $this->journalRepository = $journalRepository;
    }

    /**
     * @param int      $internshipId
     * @param string   $content
     * @param string   $date
     * @param bool     $accepted
     * @param int|null $userId
     *
     * @return JournalEntry|null
     */
    public function createJournalEntry(
        int $internshipId,
        string $content,
        string $date,
        ?bool $accepted = false,
        ?int $userId = null
    ): ?JournalEntry {
        $journalEntry = new JournalEntry();
        $journalEntry->internship_id = $internshipId;
        $journalEntry->content = $content;
        $journalEntry->user_id = $userId ?? Auth::id();
        $journalEntry->date = $date;
        $journalEntry->accepted = $accepted ?? false;
        $journalEntry->freshTimestamp();

        if ($journalEntry->save()) {
            return $journalEntry;
        }

        return null;
    }

    public function deleteStudentJournalEntry(int $studentJournalEntryId): bool
    {
        $studentJournalEntry = $this->journalRepository->getStudentJournalEntryById($studentJournalEntryId);

        if (!is_null($studentJournalEntry)) {
            $studentJournalEntry->comments()->detach();
        }

        return $studentJournalEntry->delete() ?? false;
    }

    /**
     * @param int         $studentJournalEntryId
     * @param string      $content
     * @param string|null $date
     *
     * @return JournalEntry|null
     */
    public function updateStudentJournalEntry(
        int $studentJournalEntryId,
        string $content,
        ?string $date = null
    ) : ?JournalEntry {
        $studentJournalEntry = $this->journalRepository->getStudentJournalEntryById($studentJournalEntryId);
        $journalEntry = $studentJournalEntry->journalEntry;

        if (!is_null($studentJournalEntry)) {
            $journalEntry->content = $content;
            $journalEntry->date = $date ?? $journalEntry->date;

            if ($journalEntry->update()) {
                return $journalEntry;
            }
        }

        return null;
    }

    /**
     * @param string      $name
     * @param string      $description
     * @param int         $internshipId
     * @param string|null $done_at
     * @param int|null    $userId
     *
     * @return Task|null
     */
    public function createTask(
        string $name,
        string $description,
        int $internshipId,
        ?string $done_at = null,
        ?int $userId = null
    ): ?Task {
        $task = new Task();
        $task->name = $name;
        $task->description = $description;
        $task->internship_id = $internshipId;
        $task->user_id = $userId ?? Auth::id();
        $task->done_at = $done_at;
        $task->freshTimestamp();

        if ($task->save()) {
            return $task;
        }

        return null;
    }

    /**
     * @param string   $content
     * @param int|null $userId
     *
     * @return Comment|null
     */
    public function createComment(string $content, ?int $userId = null): ?Comment
    {
        $comment = new Comment();
        $comment->content = $content;
        $comment->user_id = $userId ?? Auth::id();
        $comment->freshTimestamp();

        if ($comment->save()) {
            return $comment;
        }

        return null;
    }

    public function deleteComment(int $commentId): bool
    {
        $comment = $this->journalRepository->getStudentJournalEntryComment($commentId);

        if (!is_null($comment)) {
            DB::beginTransaction();
            $comment->studentJournalEntries()->detach();
            $deleted = $comment->delete();

            if ($deleted) {
                DB::commit();
            } else {
                DB::rollBack();
            }
        }

        return $deleted ?? false;
    }
}
