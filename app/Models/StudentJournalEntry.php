<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Student;

class StudentJournalEntry extends Model
{
    use HasFactory;

    protected $table = "students_journal_entries";

    /**
     * @return BelongsTo
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    /**
     * @return BelongsToMany
     */
    public function comments(): BelongsToMany
    {
        return $this->belongsToMany(
            Comment::class,
            'students_journal_entries_comments',
            'student_journal_entry_id',
            'comment_id'
        );
    }
}
