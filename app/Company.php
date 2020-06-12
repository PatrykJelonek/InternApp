<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = "companies";

    protected $hidden = ['pivot', 'city_id', 'company_category_id'];

    public function category()
    {
        return $this->belongsTo('App\CompanyCategory', 'company_category_id', 'id');
    }

    public function city()
    {
        return $this->belongsTo('App\City');
    }

    public function offers()
    {
        return $this->hasMany('App\Offer', 'company_id', 'id');
    }

    public function users()
    {
        return $this->belongsToMany('App\User', 'users_companies', 'company_id', 'user_id');
    }

    public static function messages()
    {
        return [
            'name.required' => 'Nazwa firmy jest wymagana!',
            'name.unique' => 'Firma o podanej nazwie istnieje już w naszym serwisie!',
            'companyCategoryId:required' => 'Kategoria firmy jest wymagana!',
            'cityId:required' => 'Miasto jest wymagane!',
            'street:required' => 'Ulica jest wymagana!',
            'streetNumber:required' => 'Numer budynku jest wymagany!',
            'email:required' => 'Email jest wymagany!',
            'phone:required' => 'Numer telefonu jest wymagany!',
            'website:required' => 'Strona internetowa jest wymagana!',
            'description:required' => 'Opis firmy jest wymagany'
        ];
    }
}
