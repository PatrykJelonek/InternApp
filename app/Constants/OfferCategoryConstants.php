<?php
/**
 * Created by PhpStorm.
 * User: Patryk Jelonek (patryk)
 * Date: 26/04/2021
 * Time: 23:18
 */

namespace App\Constants;

class OfferCategoryConstants
{
    public const CATEGORY_SOFTWARE = 'programing';
    public const CATEGORY_COMPUTER_NETWORKS = 'networks';
    public const CATEGORY_COMPUTER_GRAPHIC = 'computer_graphic';
    public const CATEGORY_COMPUTER_GAMES = 'games';

    public const BASIC_CATEGORIES = [
        self::CATEGORY_SOFTWARE,
        self::CATEGORY_COMPUTER_NETWORKS,
        self::CATEGORY_COMPUTER_GRAPHIC,
        self::CATEGORY_COMPUTER_GAMES,
    ];

    public const BASIC_CATEGORY_DESCRIPTIONS = [
        self::CATEGORY_SOFTWARE => 'Oferta związana z programowaniem.',
        self::CATEGORY_COMPUTER_NETWORKS => 'Oferta związana z sieciami komputerowymi.',
        self::CATEGORY_COMPUTER_GRAPHIC => 'Oferta związana z grafiką komputerową.',
        self::CATEGORY_COMPUTER_GAMES => 'Oferta związana z grami komputerowymi.',
    ];

    public const BASIC_CATEGORY_DISPLAY_NAMES = [
        self::CATEGORY_SOFTWARE => 'Programowanie',
        self::CATEGORY_COMPUTER_NETWORKS => 'Sieci Komputerowe',
        self::CATEGORY_COMPUTER_GRAPHIC => 'Grafika Komputerowa',
        self::CATEGORY_COMPUTER_GAMES => 'Gry Komputerowe',
    ];
}
