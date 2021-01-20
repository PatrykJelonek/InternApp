<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    protected $table = "fields";

    public function specializations()
    {
        return $this->belongsToMany('App\Models\Specialization', 'fields_specializations', 'field_id', 'specialization_id');
    }
}
