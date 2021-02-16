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

    protected $table = 'internship_statuses';
}
