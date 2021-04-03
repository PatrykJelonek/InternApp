<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agreement extends Model
{
    use HasFactory;

    protected $table ='agreements';

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

    public function universitySupervisor()
    {
        return $this->belongsTo('App\Models\User','university_supervisor_id', 'id');
    }

    public function internships()
    {
        return $this->hasMany('App\Models\Internship', 'agreement_id','id');
    }
}
