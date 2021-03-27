<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentJournalEntry extends Model
{
    use HasFactory;

    protected $table = "students_journal_entries";

    public function student(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\Student', 'student_id', 'id');
    }
}
