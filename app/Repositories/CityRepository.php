<?php
/**
 * Created by PhpStorm.
 * User: Patryk Jelonek (patryk)
 * Date: 21/04/2021
 * Time: 22:16
 */

namespace App\Repositories;

use App\Models\City;
use App\Repositories\Interfaces\CityRepositoryInterface;
use Carbon\Carbon;

class CityRepository implements CityRepositoryInterface
{

    public function getCityById(int $id)
    {
        return City::find($id);
    }

    public function getCityByPostcode(string $postcode)
    {
        return City::where(['post_code' => $postcode]);
    }

    public function getAllCities()
    {
        return City::all();
    }

    public function createCity(array $data): ?City
    {
        $city = new City();
        $city->name = $data['name'];
        $city->post_code = $data['postcode'];
        $city->created_at = Carbon::today();
        $city->updated_at = Carbon::today();

        if ($city->save()) {
            return $city;
        }

        return null;
    }

    public function updateCityById(int $id)
    {
        // TODO: Implement updateCityById() method.
    }

    public function updateCityByPostcode(string $postcode)
    {
        // TODO: Implement updateCityByPostcode() method.
    }

    public function deleteCityById(int $id)
    {
        // TODO: Implement deleteCityById() method.
    }

    public function deleteCityBySlug(string $postcode)
    {
        // TODO: Implement deleteCityBySlug() method.
    }
}
