<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agreement extends Model
{
    protected $table ='agreements';

    public function company()
    {
        return $this->belongsTo('App\Company');
    }

    public function university()
    {
        return $this->belongsTo('App\University');
    }
    
    public function offer()
    {
        return $this->belongsTo('App\Offer');
    }
}
