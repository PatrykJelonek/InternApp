<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class UserUniversity extends Model
{
    use HasFactory;

    protected $table = 'users_universities';

    public function user() {
        return $this->belongsTo(User::class, 'user_id','id');
    }

    public function university() {
        return $this->belongsTo(University::class, 'university_id', 'id');
    }

    public function roles() {
        return $this->belongsToMany(Role::class,'users_universities_roles','user_university_id', 'role_id');
    }
}
