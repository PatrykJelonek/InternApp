<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $table = "offers";

    public function company()
    {
        return $this->hasOne('App\Company');
    }

    public function user()
    {
        return $this->hasOne('App\User');
    }

    public function offerCategory()
    {
        return $this->hasOne('App\OfferCategory');
    }

    public function offerStatus()
    {
        return $this->hasOne('App\OfferStatus');
    }
    // TODO:supervisior_ids
    public static function messages()
    {
        return [
            'companyId:required' => 'Nazwa firmy jest wymagana!',
            'name:required' => 'Nazwa oferty jest wymagana!',
            'placesNumber:required' => 'Liczba miejsc jest wymagana!',
            'program:required' => 'Program jest wymagany!',
            'schedule:required' => 'Harmonogram jest wymagany!',
            'offerCategoryId:required' => 'Kategoria oferty jest wymagana!',
            'companySupervisorId:required' => 'Opiekun firmy jest wymagany !',
        ];
    }

}
