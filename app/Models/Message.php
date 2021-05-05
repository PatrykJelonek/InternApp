<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';

    public function sender()
    {
        return $this->belongsTo('App\Models\User','from_user_id','id');
    }

    public function receiver()
    {
        return $this->belongsTo('App\Models\User','to_user_id','id');
    }
}
