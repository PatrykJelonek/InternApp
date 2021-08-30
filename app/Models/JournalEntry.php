<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Ratchet\App;

class JournalEntry extends Model
{
    protected $table = "journal_entries";

    protected $appends = ['formatted_update_at'];

    public function internship(): BelongsTo
    {
        return $this->belongsTo(Internship::class, 'internship_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'students_journal_entries', 'journal_entry_id', 'student_id');
    }

    public function getFormattedUpdateAtAttribute(): string
    {
        return Carbon::parse($this->updated_at)->format('d.m.Y');
    }
}
