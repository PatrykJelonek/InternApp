<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferCategory extends Model
{
    use HasFactory;

    const CATEGORY_SOFTWARE = 'Programowanie';
    const CATEGORY_COMPUTER_NETWORKS = 'Sieci Komputerowe';
    const CATEGORY_COMPUTER_GRAPHIC = 'Grafika Komputerowa';
    const CATEGORY_COMPUTER_GAMES = 'Gry Komputerowe';

    const BASIC_CATEGORIES = [
        self::CATEGORY_SOFTWARE,
        self::CATEGORY_COMPUTER_NETWORKS,
        self::CATEGORY_COMPUTER_GRAPHIC,
        self::CATEGORY_COMPUTER_GAMES,
    ];

    const BASIC_CATEGORY_DESCRIPTIONS = [
        self::CATEGORY_SOFTWARE => 'Oferta związana z programowaniem.',
        self::CATEGORY_COMPUTER_NETWORKS => 'Oferta związana z sieciami komputerowymi.',
        self::CATEGORY_COMPUTER_GRAPHIC => 'Oferta związana z grafiką komputerową.',
        self::CATEGORY_COMPUTER_GAMES => 'Oferta związana z grami komputerowymi.',
    ];

    protected $table = 'offer_categories';
}
