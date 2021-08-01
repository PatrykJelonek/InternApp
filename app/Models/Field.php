<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Field extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "fields";

    public function specializations()
    {
        return $this->hasMany(Specialization::class, 'field_id', 'id');
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'faculty_id', 'id');
    }
}
