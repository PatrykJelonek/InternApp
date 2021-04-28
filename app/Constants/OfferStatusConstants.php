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
    public const STATUS_NEW = 'new';
    public const STATUS_ACCEPTED = 'accepted';
    public const STATUS_REJECTED = 'rejected';
    public const STATUS_DRAFT_NEW = 'draft_new';
    public const STATUS_DRAFT_ACCEPTED = 'draft_accepted';
    public const STATUS_DRAFT_REJECTED = 'draft_rejected';
    public const STATUS_STUDENT_NEW = 'student_new';
    public const STATUS_STUDENT_ACCEPTED = 'student_accepted';
    public const STATUS_STUDENT_REJECTED = 'student_rejected';

    public const STATUSES = [
        self::STATUS_NEW,
        self::STATUS_ACCEPTED,
        self::STATUS_REJECTED,
        self::STATUS_DRAFT_NEW,
        self::STATUS_DRAFT_ACCEPTED,
        self::STATUS_DRAFT_REJECTED,
        self::STATUS_STUDENT_NEW,
        self::STATUS_STUDENT_ACCEPTED,
        self::STATUS_STUDENT_REJECTED,
    ];

    public const STATUS_DESCRIPTIONS = [
        self::STATUS_NEW => 'Nowa',
        self::STATUS_ACCEPTED => 'Zaakceptowana',
        self::STATUS_REJECTED => 'Odrzucona',
        self::STATUS_DRAFT_NEW => 'Nowa',
        self::STATUS_DRAFT_ACCEPTED => 'Zaakceptowana',
        self::STATUS_DRAFT_REJECTED => 'Odrzucona',
        self::STATUS_STUDENT_NEW => 'Nowa',
        self::STATUS_STUDENT_ACCEPTED => 'Zaakceptowana',
        self::STATUS_STUDENT_REJECTED => 'Odrzucona',
    ];

    public const STATUS_DISPLAY_NAMES = [
        self::STATUS_NEW => 'Nowa',
        self::STATUS_ACCEPTED => 'Zaakceptowana',
        self::STATUS_REJECTED => 'Odrzucona',
        self::STATUS_DRAFT_NEW => 'Nowa',
        self::STATUS_DRAFT_ACCEPTED => 'Zaakceptowana',
        self::STATUS_DRAFT_REJECTED => 'Odrzucona',
        self::STATUS_STUDENT_NEW => 'Nowa',
        self::STATUS_STUDENT_ACCEPTED => 'Zaakceptowana',
        self::STATUS_STUDENT_REJECTED => 'Odrzucona',
    ];

    public const STATUS_HEX_COLORS = [
        self::STATUS_NEW => '#039BE5',
        self::STATUS_ACCEPTED => '#00E676',
        self::STATUS_REJECTED => '#D84315',
        self::STATUS_DRAFT_NEW => '#039BE5',
        self::STATUS_DRAFT_ACCEPTED => '#00E676',
        self::STATUS_DRAFT_REJECTED => '#D84315',
        self::STATUS_STUDENT_NEW => '#039BE5',
        self::STATUS_STUDENT_ACCEPTED => '#00E676',
        self::STATUS_STUDENT_REJECTED => '#D84315',
    ];
}
