<?php
/**
 * Created by PhpStorm.
 * User: Patryk Jelonek (patryk)
 * Date: 21/04/2021
 * Time: 22:54
 */

namespace App\Repositories\Interfaces;

interface OfferCategoryRepositoryInterface
{
    public function getOfferCategoryById(int $id);

    public function getOfferCategoryByName (string $name);

    public function getAllOfferCategories();

    public function createOfferCategory (array $data);

    public function updateOfferCategoryById(int $id);

    public function deleteOfferCategoryById(int $id);
}
