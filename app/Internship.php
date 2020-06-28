<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Internship extends Model
{
    protected $table = "internships";

    public function offer()
    {
        return $this->hasOne('App\Offer','id', 'offer_id');
    }

    public function agreement()
    {
        return $this->hasOne('App\Agreement','id', 'agreement_id');
    }

    public function student()
    {
        return $this->hasOne('App\Student', 'id', 'student_id');
    }

    public function status()
    {
        return $this->hasOne('App\InternshipStatus');
    }

    public function university_supervisor()
    {
        return $this->hasOne('App\User', 'id', 'university_supervisor_id');
    }

    public function company_supervisor()
    {
        return $this->hasOne('App\User', 'id', 'company_supervisor_id');
    }

    public function journals()
    {
        return $this->hasMany('App\Journal', 'internship_id', 'id');
    }
}
