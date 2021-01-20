<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    protected $table = "journal_entries";

    public function internship()
    {
        return $this->belongsTo('App\Models\Internship', 'internship_id', 'id');
    }

    public function author()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
