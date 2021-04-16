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
    const STATUS_DRAFT_NEW = 'draft_new';
    const STATUS_DRAFT_ACCEPTED = 'draft_accepted';
    const STATUS_DRAFT_REJECTED = 'draft_rejected';

    const STATUSES = [
        self::STATUS_NEW,
        self::STATUS_ACCEPTED,
        self::STATUS_REJECTED,
        self::STATUS_DRAFT_NEW,
        self::STATUS_DRAFT_ACCEPTED,
        self::STATUS_DRAFT_REJECTED,
    ];

    const STATUS_DESCRIPTIONS = [
        self::STATUS_NEW => 'Nowa',
        self::STATUS_ACCEPTED => 'Zaakceptowana',
        self::STATUS_REJECTED => 'Odrzucona',
        self::STATUS_DRAFT_NEW => 'Nowa',
        self::STATUS_DRAFT_ACCEPTED => 'Zaakceptowana',
        self::STATUS_DRAFT_REJECTED => 'Odrzucona',
    ];
}
