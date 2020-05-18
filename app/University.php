<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    protected $table = 'universities';
    protected $hidden = ['city_id', 'university_type_id', 'pivot'];

    public function type()
    {
        return $this->belongsTo('App\UniversityType', 'university_type_id', 'id');
    }

    public function city()
    {
        return $this->belongsTo('App\City');
    }

    public function users()
    {
        return $this->belongsToMany('App\User', 'users_universities', 'university_id', 'user_id');
    }
}
