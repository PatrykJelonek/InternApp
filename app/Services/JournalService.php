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
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class JournalService
{
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
}
