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

    public function faculties()
    {
        return $this->belongsToMany('App\Faculty', 'universities_faculties', 'university_id', 'faculty_id');
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
