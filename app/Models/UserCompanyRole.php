<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class UserCompanyRole extends Pivot
{
    protected $table = 'users_companies_roles';

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'users_companies_roles', 'role_id', 'id', 'user_company_id', 'id');
    }
}
