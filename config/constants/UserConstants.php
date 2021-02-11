<?php

namespace Config\Constants;

class UserConstants
{
    const USER_STATUS_ACTIVE = 'active';
    const USER_STATUS_INACTIVE = 'inactive';

    const USER_STATUSES = [
        self::USER_STATUS_ACTIVE,
        self::USER_STATUS_INACTIVE
    ];

    const USER_STATUS_DESCRIPTIONS = [
        self::USER_STATUS_ACTIVE => 'Konto aktywne',
        self::USER_STATUS_INACTIVE => 'Konto nieaktywne',
    ];
}
