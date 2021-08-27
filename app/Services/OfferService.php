<?php
/**
 * Created by PhpStorm.
 * User: Patryk Jelonek (patryk)
 * Date: 30/04/2021
 * Time: 20:28
 */

namespace App\Services;

use App\Constants\OfferStatusConstants;
use App\Models\Offer;
use App\Repositories\CompanyRepository;
use App\Repositories\OfferRepository;
use App\Repositories\OfferStatusRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OfferService
{
    /**
     * @var OfferRepository
     */
    private $offerRepository;

    /**
     * @var AttachmentService
     */
    private $attachmentService;

    /**
     * @var CompanyRepository
     */
    private $companyRepository;

    /**
     * @var OfferStatusRepository
     */
    private $offerStatusRepository;

    /**
     * OfferService constructor.
     *
     * @param OfferRepository       $offerRepository
     * @param AttachmentService     $attachmentService
     * @param CompanyRepository     $companyRepository
     * @param OfferStatusRepository $offerStatusRepository
     */
    public function __construct(
        OfferRepository $offerRepository,
        AttachmentService $attachmentService,
        CompanyRepository $companyRepository,
        OfferStatusRepository $offerStatusRepository
    ) {
        $this->offerRepository = $offerRepository;
        $this->attachmentService = $attachmentService;
        $this->companyRepository = $companyRepository;
        $this->offerStatusRepository = $offerStatusRepository;
    }

    /**
     * @param int         $companyId
     * @param string      $name
     * @param int         $places_number
     * @param string      $program
     * @param int         $offerCategoryId
     * @param string|null $schedule
     * @param string|null $dateFrom
     * @param string|null $dateTo
     * @param bool|null   $interview
     * @param int|null    $companySupervisorId
     * @param int|null    $offerStatusId
     * @param array|null  $attachments
     * @param int|null    $userId
     *
     * @return Offer|null
     */
    public function createOffer(
        int $companyId,
        string $name,
        int $places_number,
        string $program,
        int $offerCategoryId,
        ?string $schedule = null,
        ?string $dateFrom = null,
        ?string $dateTo = null,
        ?bool $interview = false,
        ?int $companySupervisorId = null,
        ?int $offerStatusId = null,
        ?array $attachments = null,
        ?int $userId = null
    ): ?Offer {
        $defaultOfferStatusId = $this->offerStatusRepository
            ->getOfferStatusByName(OfferStatusConstants::STATUS_NEW)
            ->toArray()['id'];

        $offer = new Offer();
        $offer->company_id = $companyId;
        $offer->user_id = $userId ?? Auth()->id();
        $offer->name = $name;
        $offer->places_number = $places_number;
        $offer->program = $program;
        $offer->schedule = $schedule;
        $offer->offer_category_id = $offerCategoryId;
        $offer->offer_status_id = $offerStatusId ?? $defaultOfferStatusId;
        $offer->company_supervisor_id = $companySupervisorId ?? null;
        $offer->slug = Str::slug($name);
        $offer->interview = $interview;
        $offer->date_from = $dateFrom ?? Carbon::today()->toString();
        $offer->date_to = $dateTo ?? Carbon::today()
                ->addMonths(config('global.defaultDifferenceBetweenStartAndEndOfferDate'))
                ->toString();
        $offer->freshTimestamp();

        if ($offer->save()) {
            return $offer;
        }

        return null;
    }
}
