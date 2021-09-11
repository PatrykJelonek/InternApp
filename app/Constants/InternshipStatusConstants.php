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
    public const IN_PROGRESS = 'in_progress';
    public const STATUS_ENDED= 'ended';
    public const STATUS_ENDED_BY_COMPANY = 'ended_by_company';
    public const STATUS_ENDED_BY_UNIVERSITY = 'ended_by_university';

    public const STATUS_GROUP_NEW = 'new';
    public const STATUS_GROUP_ACCEPTED = 'accepted';
    public const STATUS_GROUP_IN_PROGRESS = 'in_progress';
    public const STATUS_GROUP_ENDED = 'ended';
    public const STATUS_GROUP_ENDED_BY_COMPANY = 'ended_by_company';
    public const STATUS_GROUP_ENDED_BY_UNIVERSITY = 'ended_by_university';

    public const STATUSES = [
        self::STATUS_NEW,
        self::STATUS_ACCEPTED,
        self::IN_PROGRESS,
        self::STATUS_ENDED,
        self::STATUS_ENDED_BY_COMPANY,
        self::STATUS_ENDED_BY_UNIVERSITY,
    ];

    public const STATUSES_DISPLAY_NAME = [
        self::STATUS_NEW => 'Nowy',
        self::STATUS_ACCEPTED => 'Zaakceptowany',
        self::IN_PROGRESS => 'W trakcie',
        self::STATUS_ENDED => 'Zakończony',
        self::STATUS_ENDED_BY_COMPANY => 'Zakończony przez firmę',
        self::STATUS_ENDED_BY_UNIVERSITY => 'Zakończony przez uczelnie',
    ];

    public const STATUSES_GROUP = [
        self::STATUS_NEW => self::STATUS_GROUP_NEW,
        self::STATUS_ACCEPTED => self::STATUS_GROUP_ACCEPTED,
        self::IN_PROGRESS => self::STATUS_GROUP_IN_PROGRESS,
        self::STATUS_ENDED => self::STATUS_GROUP_ENDED,
        self::STATUS_ENDED_BY_COMPANY => self::STATUS_GROUP_ENDED_BY_COMPANY,
        self::STATUS_ENDED_BY_UNIVERSITY => self::STATUS_GROUP_ENDED_BY_UNIVERSITY,
    ];
}
