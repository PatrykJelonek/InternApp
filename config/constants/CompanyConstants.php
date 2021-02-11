<?php

namespace Config\Constants;

class CompanyConstants
{
    const COMPANY_CATEGORY_SOFTWARE = 'Oprogramowanie';
    const COMPANY_CATEGORY_COMPUTER_NETWORKS = 'Sieci Komputerowe';
    const COMPANY_CATEGORY_GAMES = 'Gry Komputerowe';
    const COMPANY_CATEGORY_GRAPHICS = 'Grafika Komputerowa';
    const COMPANY_CATEGORY_ELECTRONICS = 'Elektronika';

    const COMPANY_BASIC_CATEGORIES = [
        self::COMPANY_CATEGORY_SOFTWARE,
        self::COMPANY_CATEGORY_COMPUTER_NETWORKS,
        self::COMPANY_CATEGORY_GAMES,
        self::COMPANY_CATEGORY_GRAPHICS,
        self::COMPANY_CATEGORY_ELECTRONICS
    ];

    const COMPANY_CATEGORY_DESCRIPTIONS = [
        self::COMPANY_CATEGORY_SOFTWARE => 'Firma zajmująca się wytwarzaniem oprogramowania.',
        self::COMPANY_CATEGORY_COMPUTER_NETWORKS => 'Firma zajmująca się dostarczaniem usług z zakresu sieci komputerowych.',
        self::COMPANY_CATEGORY_GAMES => 'Firma zajmująca się tworzeniem gier komputerowych.',
        self::COMPANY_CATEGORY_GRAPHICS => 'Firma zajmująca się tworzeniem i obróbką grafiki komputerowej.',
        self::COMPANY_CATEGORY_ELECTRONICS => 'Firma zajmująca się produkcją i konserwacją urządzeń elektronicznych.'
    ];
}
