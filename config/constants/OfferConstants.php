<?php

namespace Config\Constants;

class OfferConstants
{
    const OFFER_CATEGORY_SOFTWARE = 'Programowanie';
    const OFFER_CATEGORY_COMPUTER_NETWORKS = 'Sieci Komputerowe';
    const OFFER_CATEGORY_COMPUTER_GRAPHIC = 'Grafika Komputerowa';
    const OFFER_CATEGORY_COMPUTER_GAMES = 'Gry Komputerowe';

    const OFFER_BASIC_CATEGORIES = [
        self::OFFER_CATEGORY_SOFTWARE,
        self::OFFER_CATEGORY_COMPUTER_NETWORKS,
        self::OFFER_CATEGORY_COMPUTER_GRAPHIC,
        self::OFFER_CATEGORY_COMPUTER_GAMES,
    ];

    const OFFER_BASIC_CATEGORY_DESCRIPTIONS = [
        self::OFFER_CATEGORY_SOFTWARE => 'Oferta związana z programowaniem.',
        self::OFFER_CATEGORY_COMPUTER_NETWORKS => 'Oferta związana z sieciami komputerowymi.',
        self::OFFER_CATEGORY_COMPUTER_GRAPHIC => 'Oferta związana z grafiką komputerową.',
        self::OFFER_CATEGORY_COMPUTER_GAMES => 'Oferta związana z grami komputerowymi.',
    ];

    const OFFER_STATUS_NEW = 'new';
    const OFFER_STATUS_ACCEPTED = 'accepted';
    const OFFER_STATUS_REJECTED = 'rejected';

    const OFFER_STATUSES = [
        self::OFFER_STATUS_NEW,
        self::OFFER_STATUS_ACCEPTED,
        self::OFFER_STATUS_REJECTED,
    ];

    const OFFER_STATUS_DESCRIPTIONS = [
        self::OFFER_STATUS_NEW => 'Nowa',
        self::OFFER_STATUS_ACCEPTED => 'Zaakceptowana',
        self::OFFER_STATUS_REJECTED => 'Odrzucona',
    ];
}
