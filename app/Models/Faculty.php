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
        return $this->hasMany(Field::class, 'faculty_id', 'id');
    }

    public function universities()
    {
        return $this->belongsTo(University::class, 'university_id');
    }
}
