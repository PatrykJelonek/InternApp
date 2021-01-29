<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    protected $table = 'faculties';

    public function fields()
    {
        return $this->belongsToMany('App\Models\Field', 'faculties_fields', 'faculty_id', 'field_id');
    }
}