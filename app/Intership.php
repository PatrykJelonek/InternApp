<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Intership extends Model
{
    protected $table = "interships";

    public function offer()
    {
        return $this->hasOne('App\Offer');
    }
    public function student()
    {
        return $this->hasOne('App\Student');
    }
    public function status()
    {
        return $this->hasOne('App\IntershipStatus');
    }
}
