<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    protected $table = "fields";

    public function specializations()
    {
        return $this->belongsToMany('App\Specialization', 'fields_specializations', 'field_id', 'specialization_id');
    }
}
