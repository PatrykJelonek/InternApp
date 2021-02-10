<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Internship extends Model
{
    use HasFactory;

    protected $table = "internships";

    public function offer()
    {
        return $this->hasOne('App\Models\Offer','id', 'offer_id');
    }

    public function agreement()
    {
        return $this->hasOne('App\Models\Agreement','id', 'agreement_id');
    }

    public function student()
    {
        return $this->hasOne('App\Models\Student', 'id', 'student_id');
    }

    public function status()
    {
        return $this->hasOne('App\Models\InternshipStatus');
    }

    public function universitySupervisor()
    {
        return $this->hasOne('App\Models\User', 'id', 'university_supervisor_id');
    }

    public function companySupervisor()
    {
        return $this->hasOne('App\Models\User', 'id', 'company_supervisor_id');
    }

    public function journalEntries()
    {
        return $this->hasMany('App\Models\JournalEntry', 'internship_id', 'id');
    }
}
