<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Internship extends Model
{
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

    public function university_supervisor()
    {
        return $this->hasOne('App\Models\User', 'id', 'university_supervisor_id');
    }

    public function company_supervisor()
    {
        return $this->hasOne('App\Models\User', 'id', 'company_supervisor_id');
    }

    public function journals()
    {
        return $this->hasMany('App\Models\Journal', 'internship_id', 'id');
    }
}
