<?php
/**
 * Created by PhpStorm.
 * User: Patryk Jelonek (patryk)
 * Date: 10/04/2021
 * Time: 21:58
 */
namespace App\Constants;

class InternshipStatusConstants
{
    public const STATUS_NEW = 'new';
    public const STATUS_ACCEPTED = 'accepted';
    public const STATUS_ENDED= 'ended';

    public const STATUSES = [
        self::STATUS_NEW,
        self::STATUS_ACCEPTED,
        self::STATUS_ENDED,
    ];

    public const STATUSES_DISPLAYED_NAME = [
        self::STATUS_NEW => 'Nowy',
        self::STATUS_ACCEPTED => 'Zaakceptowany',
        self::STATUS_ENDED => 'Zakończony',
    ];
}
