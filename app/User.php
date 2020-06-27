<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Laratrust\Traits\LaratrustUserTrait;

class User extends Model implements AuthenticatableContract, JWTSubject
{
    use LaratrustUserTrait;
    use Authenticatable;

    protected $table = 'users';

    protected $hidden = ['password_hash', 'remember_token', 'user_status_id', 'password_reset_token'];

    public function getAuthPassword () {
        return $this->password_hash;
    }

    public function status()
    {
        return $this->hasOne('App\UserStatuses');
    }

    public function student()
    {
        return $this->hasOne('App\Student', 'user_id', 'id');
    }

    public function roles()
    {
        return $this->belongsToMany('App\Role', 'users_roles', 'user_id', 'role_id');
    }

    public function journals()
    {
        return $this->hasMany('App\Journal', 'user_id', 'id');
    }

    public function companySupervisorInternships()
    {
        return $this->hasMany('App\Internship', 'company_supervisor_id', 'id');
    }

    public function universitySupervisorInternships()
    {
        return $this->hasMany('App\Internship', 'university_supervisor_id', 'id');
    }

    public function universities()
    {
          return $this->belongsToMany('App\University', 'users_universities', 'user_id', 'university_id')->with(['city','type']);
    }

    public function companies()
    {
        return $this->belongsToMany('App\Company', 'users_companies', 'user_id', 'company_id')->with(['city', 'category']);
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
