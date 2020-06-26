<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    protected $table = "journal_entries";

    public function internship()
    {
        return $this->belongsTo('App\Internship', 'internship_id', 'id');
    }

    public function author()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
