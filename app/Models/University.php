<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    use HasFactory;

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
        return $this->belongsToMany('App\Models\User', 'users_universities', 'university_id', 'user_id')->withPivot(['id','active']);
    }

    public function faculties()
    {
        return $this->belongsToMany('App\Models\Faculty', 'universities_faculties', 'university_id', 'faculty_id');
    }

    public function agreements()
    {
        return $this->hasMany('App\Models\Agreement', 'university_id', 'id');
    }

    public function questionnaires()
    {
        return $this->belongsToMany('App\Models\Questionnaire','universities_questionnaires','university_id', 'questionnaire_id');
    }

    public static function messages()
    {
        return [
            'name.required' => 'Nazwa uczelni jest wymagana!',
            'universityTypeId:required' => 'Rodzaj uczelni jest wymagany!',
            'cityId:required' => 'Miasto jest wymagane!',
            'street:required' => 'Ulica jest wymagana!',
            'streetNumber:required' => 'Numer budynku jest wymagany!',
            'email:required' => 'Email jest wymagany!',
            'phone:required' => 'Numer telefonu jest wymagany!',
            'website:required' => 'Strona internetowa jest wymagana!'
        ];
    }
}
