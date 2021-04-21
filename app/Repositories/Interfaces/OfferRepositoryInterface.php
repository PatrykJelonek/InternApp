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

    public function getAllOffers(array $categories);

    public function createOffer(array $data);

    public function updateOfferBySlug(string $slug);

    public function deleteOfferBySlug(string $slug);
}
