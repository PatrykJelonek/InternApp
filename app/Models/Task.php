<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laratrust\Contracts\Ownable;

class Task extends Model implements Ownable
{
    protected $table = "tasks";

    public function internship()
    {
        return $this->belongsTo('App\Models\Internship','internship_id', 'id');
    }

    public function user()
    {
        return $this->hasOne('App\Models\User');
    }

    public function ownerKey($owner)
    {
        if($this->internship->company_supervisor_id === $owner->id) {
            return $owner->id;
        }

        if($this->internship->university_supervisor_id === $owner->id) {
            return $owner->id;
        }

        if($this->internship->student->user_id === $owner->id) {
            return $owner->id;
        }

        return $this->user_id;
    }
}
