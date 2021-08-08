<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    public const COMPANY_CATEGORY_SOFTWARE = 'Oprogramowanie';
    public const COMPANY_CATEGORY_COMPUTER_NETWORKS = 'Sieci Komputerowe';
    public const COMPANY_CATEGORY_GAMES = 'Gry Komputerowe';
    public const COMPANY_CATEGORY_GRAPHICS = 'Grafika Komputerowa';
    public const COMPANY_CATEGORY_ELECTRONICS = 'Elektronika';

    public const COMPANY_BASIC_CATEGORIES = [
        self::COMPANY_CATEGORY_SOFTWARE,
        self::COMPANY_CATEGORY_COMPUTER_NETWORKS,
        self::COMPANY_CATEGORY_GAMES,
        self::COMPANY_CATEGORY_GRAPHICS,
        self::COMPANY_CATEGORY_ELECTRONICS,
    ];

    public const COMPANY_CATEGORY_DESCRIPTIONS = [
        self::COMPANY_CATEGORY_SOFTWARE => 'Firma zajmująca się wytwarzaniem oprogramowania.',
        self::COMPANY_CATEGORY_COMPUTER_NETWORKS => 'Firma zajmująca się dostarczaniem usług z zakresu sieci komputerowych.',
        self::COMPANY_CATEGORY_GAMES => 'Firma zajmująca się tworzeniem gier komputerowych.',
        self::COMPANY_CATEGORY_GRAPHICS => 'Firma zajmująca się tworzeniem i obróbką grafiki komputerowej.',
        self::COMPANY_CATEGORY_ELECTRONICS => 'Firma zajmująca się produkcją i konserwacją urządzeń elektronicznych.',
    ];

    use HasFactory, SoftDeletes;

    protected $table = "companies";

    protected $hidden = ['city_id', 'company_category_id', 'access_code'];

    protected $appends = ['full_address', 'draft_name', 'draft_email'];

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
        return $this->belongsToMany('App\Models\User', 'users_companies', 'company_id', 'user_id')->withPivot(['id','active','created_at']);
    }

    public function questionnaires()
    {
        return $this->belongsToMany('App\Models\Questionnaire','companies_questionnaires','company_id', 'questionnaire_id');
    }

    public function author()
    {
        return $this->hasOne(User::class, 'user_id','id');
    }

    public function getFullAddressAttribute(): string
    {
        return "{$this->street} {$this->street_number}, {$this->city->post_code} {$this->city->name}";
    }

    public function getDraftNameAttribute()
    {
        return preg_replace('/(__(\d|[a-z])*__draft__)/','', $this->name);
    }

    public function getDraftEmailAttribute()
    {
        return preg_replace('/(__(\d|[a-z])*__draft__)/','', $this->email);
    }
}
