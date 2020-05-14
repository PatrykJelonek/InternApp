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
}
