<?php
/**
 * Created by PhpStorm.
 * User: Patryk Jelonek (patryk)
 * Date: 21/04/2021
 * Time: 22:15
 */

namespace App\Repositories\Interfaces;

interface CityRepositoryInterface
{
    public function getCityById(int $id);

    public function getCityByPostcode(string $postcode);

    public function getAllCities();

    public function createCity(array $data);

    public function updateCityById(int $id);

    public function updateCityByPostcode(string $postcode);

    public function deleteCityById(int $id);

    public function deleteCityBySlug(string $postcode);
}
