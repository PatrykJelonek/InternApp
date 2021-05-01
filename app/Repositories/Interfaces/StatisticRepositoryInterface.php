<?php
/**
 * Created by PhpStorm.
 * User: Patryk Jelonek (patryk)
 * Date: 23/04/2021
 * Time: 22:07
 */

namespace App\Repositories\Interfaces;

interface StatisticRepositoryInterface
{
    public function getNumberOfAllOffers();

    public function getNumberOfAllUsers();

    public function getNumberOfAllAgreements();

    public function getNumberOfAllUniversities();

    public function getNumberOfAllCompanies();

    public function getNumberOfAllAttachments();

    public function getNumberOfAllOffersAttachments();

    public function getNumberOfAllNewOffers();
}
