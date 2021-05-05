<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $table = "offers";

    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\OfferCategory','offer_category_id','id');
    }

    public function status()
    {
        return $this->hasOne('App\Models\OfferStatus', 'id', 'offer_status_id');
    }

    public function supervisor()
    {
        return $this->hasOne('App\Models\User', 'id', 'company_supervisor_id');
    }

    public function internships()
    {
        return $this->hasMany('App\Models\Internship', 'offer_id', 'id');

    }

    public function scopeWithPlaces($query)
    {
        return $query->where('places_number', '>', 0);
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
