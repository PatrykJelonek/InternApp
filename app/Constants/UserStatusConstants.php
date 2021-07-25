<?php
/**
 * Created by PhpStorm.
 * User: Patryk Jelonek (patryk)
 * Date: 25/07/2021
 * Time: 23:32
 */

namespace App\Constants;

class UserStatusConstants
{
    public const USER_STATUS_ACTIVE = 'active';
    public const USER_STATUS_INACTIVE = 'inactive';

    public const USER_STATUSES = [
        self::USER_STATUS_ACTIVE,
        self::USER_STATUS_INACTIVE
    ];

    public const USER_STATUS_DESCRIPTIONS = [
        self::USER_STATUS_ACTIVE => 'Aktywne',
        self::USER_STATUS_INACTIVE => 'Nieaktywne',
    ];
}
