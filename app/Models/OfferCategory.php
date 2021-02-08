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
        self::CATEGORY_COMPUTER_GAMES
    ];

    protected $table = 'offer_categories';
}
