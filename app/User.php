<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class User extends Model implements AuthenticatableContract
{
    use Authenticatable;

    protected $table = 'users';

    public function getAuthPassword () {
        return $this->password_hash;
    }

    public function status()
    {
        return $this->hasOne('App\UserStatuses');
    }
}
