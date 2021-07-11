<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $table = "students";

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function internships()
    {
        return $this->belongsToMany('App\Models\Internship','internships_students','student_id','internship_id');
    }

    public function specialization()
    {
        return $this->hasOne('App\Models\Specialization', 'id', 'specialization_id')->withTrashed();
    }

    public function journalEntries()
    {
        return $this->belongsToMany('App\Models\JournalEntry','students_journal_entries','student_id','journal_entry_id');
    }

    public function tasks()
    {
        return $this->belongsToMany('App\Models\Task', 'students_tasks','student_id','task_id');
    }
}
