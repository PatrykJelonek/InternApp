<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Company;
use App\Models\User;
use App\Models\OfferCategory;
use App\Models\OfferStatus;
use App\Models\Internship;
use Ratchet\App;

class Offer extends Model
{
    use HasFactory;

    protected $table = "offers";

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(OfferCategory::class, 'offer_category_id', 'id');
    }

    public function status()
    {
        return $this->hasOne(OfferStatus::class, 'id', 'offer_status_id');
    }

    public function supervisor()
    {
        return $this->hasOne(User::class, 'id', 'company_supervisor_id');
    }

    public function internships()
    {
        return $this->hasMany(Internship::class, 'offer_id', 'id');

    }

    public function attachments()
    {
        return $this->belongsToMany(Attachment::class,'offers_attachments', 'offer_id', 'attachment_id');
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
