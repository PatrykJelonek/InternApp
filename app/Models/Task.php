<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laratrust\Contracts\Ownable;

class Task extends Model
{
    protected $table = "tasks";

    public function internship(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\Internship', 'internship_id', 'id');
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
