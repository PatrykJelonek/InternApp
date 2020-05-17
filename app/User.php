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

    public function getAuthPassword () {
        return $this->password_hash;
    }

    public function status()
    {
        return $this->hasOne('App\UserStatuses');
    }

    public function roles()
    {
        return $this->belongsToMany('App\Role', 'users_roles', 'user_id', 'role_id');
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
