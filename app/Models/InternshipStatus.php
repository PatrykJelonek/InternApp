<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InternshipStatus extends Model
{
    const STATUS_NEW = 'new';
    const STATUS_ACCEPTED = 'accepted';

    const STATUSES = [
        self::STATUS_NEW,
        self::STATUS_ACCEPTED
    ];

    const STATUSES_DISPLAYED_NAME = [
        self::STATUS_NEW => 'Nowy',
        self::STATUS_ACCEPTED => 'Zaakceptowany'
    ];

    protected $table = 'internship_statuses';
}
