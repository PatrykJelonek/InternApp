<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $table = "attachments";

    public function user()
    {
        return $this->hasOne('App\Models\User');
    }
}
