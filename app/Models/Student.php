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
        return $this->hasMany('App\Models\Internship', 'student_id', 'id');
    }
}
