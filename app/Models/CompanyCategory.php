<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyCategory extends Model
{
    use HasFactory;

    const CATEGORY_SOFTWARE = 'Oprogramowanie';
    const CATEGORY_COMPUTER_NETWORKS = 'Sieci Komputerowe';
    const CATEGORY_GAMES = 'Gry Komputerowe';
    const CATEGORY_GRAPHICS = 'Grafika Komputerowa';
    const CATEGORY_ELECTRONICS = 'Elektronika';

    const BASIC_CATEGORIES = [
        self::CATEGORY_SOFTWARE,
        self::CATEGORY_COMPUTER_NETWORKS,
        self::CATEGORY_GAMES,
        self::CATEGORY_GAMES,
        self::CATEGORY_GRAPHICS,
        self::CATEGORY_ELECTRONICS
    ];

    protected $table = "company_categories";
}
