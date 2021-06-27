<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class UserCompanyRole extends Model
{
    protected $table = 'users_companies_roles';

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }
}
