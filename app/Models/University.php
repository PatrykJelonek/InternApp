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

    protected $appends = ['full_address'];

    public function type()
    {
        return $this->belongsTo(UniversityType::class, 'university_type_id', 'id');
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_universities', 'university_id', 'user_id')->withPivot(
            ['id', 'active']
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function faculties()
    {
        return $this->hasMany(Faculty::class, 'university_id', 'id');
    }

    public function agreements()
    {
        return $this->hasMany(Agreement::class, 'university_id', 'id');
    }

    public function questionnaires()
    {
        return $this->belongsToMany(
            Questionnaire::class,
            'universities_questionnaires',
            'university_id',
            'questionnaire_id'
        );
    }

    public function roles()
    {
        return $this->hasMany(UserUniversity::class);
    }

    public function getFullAddressAttribute()
    {
        return "{$this->street} {$this->street_number}, {$this->city->post_code} {$this->city->name}";
    }
}
