<?php

namespace Config\Constants;

class UniversityConstants
{
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
}
