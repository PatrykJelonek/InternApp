<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    protected $table = 'Universities';

    public function type()
    {
        return $this->hasOne('App\UniversityType');
    }

    public function city()
    {
        return $this->hasOne('App\City');
    }
}
