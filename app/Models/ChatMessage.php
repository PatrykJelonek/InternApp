<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ChatMessage extends Model
{
    use HasFactory;

    public $hidden = [];

    public function user(): HasOne
    {
        return $this->hasOne(User::class,'id','user_id');
    }

    public function chat(): HasOne
    {
        return $this->hasOne(Chat::class, 'chat_uuid', 'uuid');
    }
}
