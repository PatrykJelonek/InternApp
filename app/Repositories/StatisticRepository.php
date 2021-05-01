<?php
/**
 * Created by PhpStorm.
 * User: Patryk Jelonek (patryk)
 * Date: 23/04/2021
 * Time: 22:10
 */

namespace App\Repositories;

use App\Constants\OfferStatusConstants;
use App\Models\Agreement;
use App\Models\Attachment;
use App\Models\Company;
use App\Models\Offer;
use App\Models\OfferAttachment;
use App\Models\University;
use App\Models\User;
use App\Repositories\Interfaces\StatisticRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

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

    public function getNumberOfAllNewOffers()
    {
        return Offer::whereHas(
            'status',
            function (Builder $query) {
                $query->where(
                    [
                        'name' => [
                            OfferStatusConstants::STATUS_NEW,
                            OfferStatusConstants::STATUS_DRAFT_NEW,
                            OfferStatusConstants::STATUS_STUDENT_NEW,
                        ],
                    ]
                );
            }
        )->count();
    }
}
