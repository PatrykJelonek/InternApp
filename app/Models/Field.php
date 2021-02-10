<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    use HasFactory;

    protected $table = "fields";

    public function specializations()
    {
        return $this->belongsToMany('App\Models\Specialization', 'fields_specializations', 'field_id', 'specialization_id');
    }
}
