<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = "companies";

    public function category()
    {
        return $this->hasOne('App\CompaniesCategory');
    }

    public function city()
    {
        return $this->hasOne('App\City');
    }
}
