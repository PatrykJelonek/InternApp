<?php
/**
 * Created by PhpStorm.
 * User: Patryk Jelonek (patryk)
 * Date: 21/04/2021
 * Time: 22:54
 */

namespace App\Repositories\Interfaces;

interface OfferStatusRepositoryInterface
{
    public function getOfferStatusById(int $id);

    public function getOfferStatusByName (string $name);

    public function getAllOfferStatuses();

    public function createOfferStatus (array $data);

    public function updateOfferStatusById(int $id);

    public function deleteOfferStatusById(int $id);
}
