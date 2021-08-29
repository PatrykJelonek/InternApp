<?php
/**
 * Created by PhpStorm.
 * User: Patryk Jelonek (patryk)
 * Date: 29/08/2021
 * Time: 12:47
 */

namespace App\Services;

use App\Models\City;
use App\Repositories\CityRepository;

class CityService
{
    /**
     * @var CityRepository
     */
    private $cityRepository;

    /**
     * @param CityRepository $cityRepository
     */
    public function __construct(CityRepository $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    /**
     * @param string $name
     * @param string $postcode
     *
     * @return City|null
     */
    public function createCity(string $name, string $postcode): ?City
    {
        $city = new City();
        $city->name = $name;
        $city->post_code = $postcode;
        $city->freshTimestamp();

        if ($city->save()) {
            return $city;
        }

        return null;
    }
}
