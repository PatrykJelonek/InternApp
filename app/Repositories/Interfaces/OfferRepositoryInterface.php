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
    public function one(string $slug);

    public function all(array $categories);

    public function create();

    public function edit(string $slug);

    public function delete(string $slug);
}
