<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = "students";

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function internships()
    {
        return $this->hasMany('App\Internship', 'student_id', 'id');
    }
}
