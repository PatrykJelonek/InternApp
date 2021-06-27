<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserUniversityRole extends Model
{
    use HasFactory;

    protected $table = 'users_university_roles';

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }
}
