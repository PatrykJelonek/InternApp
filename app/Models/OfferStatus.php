<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferStatus extends Model
{
    use HasFactory;
    use HasTimestamps;

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

    protected $table = 'offer_statuses';
}
