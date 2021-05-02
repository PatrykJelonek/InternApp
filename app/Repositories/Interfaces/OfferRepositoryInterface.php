<?php
/**
 * Created by PhpStorm.
 * User: Patryk Jelonek (patryk)
 * Date: 05/04/2021
 * Time: 18:35
 */
namespace App\Repositories\Interfaces;

interface OfferRepositoryInterface
{
    public function getOfferById(int $id);

    public function getOfferBySlug(string $slug);

    public function getAllOffers(?array $categories = null, ?array $statuses = null,?bool $onlyWithPlaces = false, ?int $limit = null);

    public function createOffer(array $data);

    public function updateOffer(array $data, ?int $offerId  = null, ?string $offerSlug = null);

    public function updateOfferBySlug(string $slug);

    public function deleteOfferBySlug(string $slug);

    public function acceptOfferBySlug(string $slug);

    public function rejectOfferBySlug(string $slug);
}
