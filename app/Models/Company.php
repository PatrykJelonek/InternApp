<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    const COMPANY_CATEGORY_SOFTWARE = 'Oprogramowanie';
    const COMPANY_CATEGORY_COMPUTER_NETWORKS = 'Sieci Komputerowe';
    const COMPANY_CATEGORY_GAMES = 'Gry Komputerowe';
    const COMPANY_CATEGORY_GRAPHICS = 'Grafika Komputerowa';
    const COMPANY_CATEGORY_ELECTRONICS = 'Elektronika';

    const COMPANY_BASIC_CATEGORIES = [
        self::COMPANY_CATEGORY_SOFTWARE,
        self::COMPANY_CATEGORY_COMPUTER_NETWORKS,
        self::COMPANY_CATEGORY_GAMES,
        self::COMPANY_CATEGORY_GRAPHICS,
        self::COMPANY_CATEGORY_ELECTRONICS
    ];

    const COMPANY_CATEGORY_DESCRIPTIONS = [
        self::COMPANY_CATEGORY_SOFTWARE => 'Firma zajmująca się wytwarzaniem oprogramowania.',
        self::COMPANY_CATEGORY_COMPUTER_NETWORKS => 'Firma zajmująca się dostarczaniem usług z zakresu sieci komputerowych.',
        self::COMPANY_CATEGORY_GAMES => 'Firma zajmująca się tworzeniem gier komputerowych.',
        self::COMPANY_CATEGORY_GRAPHICS => 'Firma zajmująca się tworzeniem i obróbką grafiki komputerowej.',
        self::COMPANY_CATEGORY_ELECTRONICS => 'Firma zajmująca się produkcją i konserwacją urządzeń elektronicznych.'
    ];

    protected $table = "companies";

    protected $hidden = ['pivot', 'city_id', 'company_category_id'];

    public function category()
    {
        return $this->belongsTo('App\Models\CompanyCategory', 'company_category_id', 'id');
    }

    public function city()
    {
        return $this->belongsTo('App\Models\City');
    }

    public function offers()
    {
        return $this->hasMany('App\Models\Offer', 'company_id', 'id');
    }

    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'users_companies', 'company_id', 'user_id');
    }

    public function questionnaires()
    {
        return $this->belongsToMany('App\Models\Questionnaire','companies_questionnaires','company_id', 'questionnaire_id');
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
