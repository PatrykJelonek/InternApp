<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class JournalEntry extends Model
{
    protected $table = "journal_entries";
    protected $appends = ['formatted_update_at'];

    public function internship()
    {
        return $this->belongsTo('App\Models\Internship', 'internship_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function getFormattedUpdateAtAttribute()
    {
        return Carbon::parse($this->updated_at)->format('d.m.Y');
    }
}
