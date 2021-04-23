<?php
/**
 * Created by PhpStorm.
 * User: Patryk Jelonek (patryk)
 * Date: 23/04/2021
 * Time: 22:10
 */

namespace App\Repositories;

use App\Models\Agreement;
use App\Models\Attachment;
use App\Models\Company;
use App\Models\Offer;
use App\Models\OfferAttachment;
use App\Models\University;
use App\Models\User;
use App\Repositories\Interfaces\StatisticRepositoryInterface;

class StatisticRepository implements StatisticRepositoryInterface
{

    public function getNumberOfAllOffers()
    {
        return Offer::count();
    }

    public function getNumberOfAllUsers()
    {
        return User::count();
    }

    public function getNumberOfAllAgreements()
    {
        return Agreement::count();
    }

    public function getNumberOfAllUniversities()
    {
        return University::count();
    }

    public function getNumberOfAllCompanies()
    {
        return Company::count();
    }

    public function getNumberOfAllAttachments()
    {
        return Attachment::count();
    }

    public function getNumberOfAllOffersAttachments()
    {
        return OfferAttachment::count();
    }
}
