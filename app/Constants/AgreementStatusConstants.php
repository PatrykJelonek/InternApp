<?php
/**
 * Created by PhpStorm.
 * User: Patryk Jelonek (patryk)
 * Date: 02/05/2021
 * Time: 01:59
 */

namespace App\Constants;

class AgreementStatusConstants
{
    public const STATUS_NEW = 'new';
    public const STATUS_ACCEPTED = 'accepted';
    public const STATUS_REJECTED = 'rejected';

    public const STATUSES = [
        self::STATUS_NEW,
        self::STATUS_ACCEPTED,
        self::STATUS_REJECTED,
    ];

    public const STATUS_DESCRIPTIONS = [
        self::STATUS_NEW => 'Nowa',
        self::STATUS_ACCEPTED => 'Zaakceptowana',
        self::STATUS_REJECTED => 'Odrzucona',
    ];


    public const STATUS_DISPLAY_NAMES = [
        self::STATUS_NEW => 'Nowa',
        self::STATUS_ACCEPTED => 'Zaakceptowana',
        self::STATUS_REJECTED => 'Odrzucona',
    ];

    public const STATUS_HEX_COLORS = [
        self::STATUS_NEW => '#E3F2FD',
        self::STATUS_ACCEPTED => '#C8E6C9',
        self::STATUS_REJECTED => '#FFCDD2',

    ];

    public const STATUS_GROUP = [
        self::STATUS_NEW => 'new',
        self::STATUS_ACCEPTED => 'accepted',
        self::STATUS_REJECTED => 'rejected',
    ];
}
