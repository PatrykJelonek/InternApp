<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class University extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'universities';

    protected $hidden = ['city_id', 'university_type_id'];

    public function type()
    {
        return $this->belongsTo('App\Models\UniversityType', 'university_type_id', 'id');
    }

    public function city()
    {
        return $this->belongsTo('App\Models\City');
    }

    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'users_universities', 'university_id', 'user_id')->withPivot(
            ['id', 'active']
        );
    }

    public function faculties()
    {
        return $this->hasMany('App\Models\Faculty', 'university_id', 'id');
    }

    public function agreements()
    {
        return $this->hasMany('App\Models\Agreement', 'university_id', 'id');
    }

    public function questionnaires()
    {
        return $this->belongsToMany(
            'App\Models\Questionnaire',
            'universities_questionnaires',
            'university_id',
            'questionnaire_id'
        );
    }

    public function roles()
    {
        return $this->hasMany(UserUniversity::class);
    }
}
