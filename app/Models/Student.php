<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Task;
use App\Models\JournalEntry;
use App\Models\Internship;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Student extends Model
{
    use HasFactory;

    protected $table = "students";

    /**
     * @return HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * @return BelongsToMany
     */
    public function internships(): BelongsToMany
    {
        return $this->belongsToMany(Internship::class, 'internships_students', 'student_id', 'internship_id');
    }

    /**
     * @return mixed
     */
    public function specialization(): HasOne
    {
        return $this->hasOne(Specialization::class, 'id', 'specialization_id')->withTrashed();
    }

    /**
     * @return BelongsToMany
     */
    public function journalEntries(): BelongsToMany
    {
        return $this->belongsToMany(JournalEntry::class, 'students_journal_entries', 'student_id', 'journal_entry_id')->withPivot(['id','accepted']);
    }

    /**
     * @return BelongsToMany
     */
    public function tasks(): BelongsToMany
    {
        return $this->belongsToMany(Task::class, 'students_tasks', 'student_id', 'task_id')->withPivot(['done_at']);
    }
}
