<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laratrust\Traits\LaratrustUserTrait;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Model implements AuthenticatableContract, JWTSubject
{
    use LaratrustUserTrait;
    use Authenticatable;
    use HasFactory;

    protected $table = 'users';

    protected $hidden = ['password_hash', 'remember_token', 'user_status_id', 'password_reset_token'];

    public function getAuthPassword () {
        return $this->password_hash;
    }

    public function status()
    {
        return $this->hasOne('App\Models\UserStatuses');
    }

    public function student()
    {
        return $this->hasOne('App\Models\Student', 'user_id', 'id');
    }

    public function roles()
    {
        return $this->belongsToMany('App\Models\Role', 'users_roles', 'user_id', 'role_id');
    }

    public function permissions()
    {
        return $this->belongsToMany('App\Models\Permission', 'users_permissions', 'user_id', 'permission_id');
    }

    public function journals()
    {
        return $this->hasMany('App\Models\JournalEntry', 'user_id', 'id');
    }

    public function companySupervisorInternships()
    {
        return $this->hasMany('App\Models\Internship', 'company_supervisor_id', 'id');
    }

    public function universitySupervisorInternships()
    {
        return $this->hasMany('App\Models\Internship', 'university_supervisor_id', 'id');
    }

    public function universities()
    {
          return $this->belongsToMany('App\Models\University', 'users_universities', 'user_id', 'university_id')->with(['city','type']);
    }

    public function companies()
    {
        return $this->belongsToMany('App\Models\Company', 'users_companies', 'user_id', 'company_id')->with(['city', 'category']);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
