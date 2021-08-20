<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Model implements AuthenticatableContract, JWTSubject, CanResetPassword
{
    use LaratrustUserTrait;
    use Authenticatable;
    use HasFactory;
    use Notifiable;

    protected $table = 'users';

    protected $hidden = ['password_hash', 'remember_token', 'user_status_id', 'password_reset_token'];
    protected $appends = ['full_name'];

    public function getAuthPassword () {
        return $this->password_hash;
    }

    public function status()
    {
        return $this->hasOne('App\Models\UserStatus','id','user_status_id');
    }

    public function student()
    {
        return $this->hasOne('App\Models\Student', 'user_id', 'id');
    }

    /**
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'users_roles', 'user_id', 'role_id');
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
          return $this->belongsToMany('App\Models\University', 'users_universities', 'user_id', 'university_id')->with(['city','type'])->withPivot(['active', 'verified']);
    }

    public function universitiesWithRoles()
    {
        return $this->hasMany(UserUniversity::class)->with(['university','roles']);
    }

    public function companiesWithRoles()
    {
        return $this->hasMany(UserCompany::class)->with(['company','roles']);
    }

    public function companies()
    {
        return $this->belongsToMany('App\Models\Company', 'users_companies', 'user_id', 'company_id')->with(['city', 'category']);
    }

    public function messagesSender()
    {
        return $this->hasMany('App\Models\Message','from_user_id','id');
    }

    public function messagesReceiver()
    {
        return $this->hasMany('App\Models\Message','to_user_id', 'id');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getEmailForPasswordReset()
    {
        // TODO: Implement getEmailForPasswordReset() method.
    }

    public function sendPasswordResetNotification($token)
    {
        // TODO: Implement sendPasswordResetNotification() method.
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
