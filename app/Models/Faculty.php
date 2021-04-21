<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    use HasFactory;

    protected $table = 'faculties';

    public function fields()
    {
        return $this->belongsToMany('App\Models\Field', 'faculties_fields', 'faculty_id', 'field_id');
    }

    public function universities()
    {
        return $this->belongsToMany('App\Models\University', 'universities_faculties', 'faculty_id', 'university_id');
    }
}
