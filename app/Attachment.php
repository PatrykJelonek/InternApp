<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $table = "attachments";

    public function user()
    {
        return $this->hasOne('App\User');
    }
}
