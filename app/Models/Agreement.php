<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agreement extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'agreements';

    protected $casts = [
        'date_from' => 'date:d.m.Y',
        'date_to' => 'date:d.m.Y',
    ];


    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }

    public function university()
    {
        return $this->belongsTo('App\Models\University');
    }

    public function offer()
    {
        return $this->belongsTo('App\Models\Offer');
    }

    public function author()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function supervisor()
    {
        return $this->belongsTo('App\Models\User', 'university_supervisor_id', 'id');
    }

    public function internships()
    {
        return $this->hasMany('App\Models\Internship', 'agreement_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo('App\Models\AgreementStatus', 'agreement_status_id', 'id');
    }
}
