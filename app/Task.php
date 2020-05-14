<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = "tasks";

    public function internship()
    {
        return $this->hasOne('App\Internship');
    }

    public function user()
    {
        return $this->hasOne('App\User');
    }
}
