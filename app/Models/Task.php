<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = "tasks";

    public function internship()
    {
        return $this->hasOne('App\Models\Internship');
    }

    public function user()
    {
        return $this->hasOne('App\Models\User');
    }
}
