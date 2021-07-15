<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class UserUniversityRole extends Pivot
{
    protected $table = 'users_universities_roles';

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'users_universities_roles', 'role_id', 'id', 'user_university_id', 'id');
    }
}
