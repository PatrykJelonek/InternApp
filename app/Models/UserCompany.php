<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class UserCompany extends Model
{
    use HasFactory;

    protected $table = 'users_companies';

    public function user() {
        return $this->belongsTo(User::class, 'user_id','id');
    }

    public function company() {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function roles() {
        return $this->belongsToMany(Role::class,'users_companies_roles','user_company_id', 'role_id', 'id');
    }
}
