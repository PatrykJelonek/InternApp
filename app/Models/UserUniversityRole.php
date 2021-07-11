<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class UserUniversityRole extends Pivot
{
    protected $table = 'users_university_roles';

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'users_universities_roles', 'user_universities_id', 'id', 'role_id', 'id');
    }
}
