<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserStatus extends Model
{
    const USER_STATUS_ACTIVE = 'active';
    const USER_STATUS_INACTIVE = 'inactive';

    const USER_STATUSES = [
        self::USER_STATUS_ACTIVE,
        self::USER_STATUS_INACTIVE
    ];

    const USER_STATUS_DESCRIPTIONS = [
        self::USER_STATUS_ACTIVE => 'Aktywne',
        self::USER_STATUS_INACTIVE => 'Nieaktywne',
    ];

    protected $table = 'user_statuses';
}
