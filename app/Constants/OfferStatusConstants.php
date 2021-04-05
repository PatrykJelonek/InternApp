<?php
/**
 * Created by PhpStorm.
 * User: Patryk Jelonek (patryk)
 * Date: 05/04/2021
 * Time: 18:52
 */

namespace App\Constants;

class OfferStatusConstants
{
    const STATUS_NEW = 'new';
    const STATUS_ACCEPTED = 'accepted';
    const STATUS_REJECTED = 'rejected';

    const STATUSES = [
        self::STATUS_NEW,
        self::STATUS_ACCEPTED,
        self::STATUS_REJECTED,
    ];

    const STATUS_DESCRIPTIONS = [
        self::STATUS_NEW => 'Nowa',
        self::STATUS_ACCEPTED => 'Zaakceptowana',
        self::STATUS_REJECTED => 'Odrzucona',
    ];
}
