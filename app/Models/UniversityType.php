<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UniversityType extends Model
{
    use HasFactory;

    const UNIVERSITY_TYPE_UNIVERSITY = 'Uniwersytet';
    const UNIVERSITY_TYPE_WYZSZA_SZKOLA_ZAWODOWA = 'Wyższa Szkoła Zawodowa';

    const BASIC_UNIVERSITY_TYPES = [
        self::UNIVERSITY_TYPE_UNIVERSITY,
        self::UNIVERSITY_TYPE_WYZSZA_SZKOLA_ZAWODOWA,
    ];

    const BASIC_UNIVERSITY_TYPE_DESCRIPTION = [
        self::UNIVERSITY_TYPE_UNIVERSITY => 'Uniwersytet',
        self::UNIVERSITY_TYPE_WYZSZA_SZKOLA_ZAWODOWA => 'Wyższa Szkoła Zawodowa'
    ];

    protected $table = 'university_types';
}
