<?php
/**
 * Created by PhpStorm.
 * User: Patryk Jelonek (patryk)
 * Date: 01/05/2021
 * Time: 23:23
 */

namespace App\Services;

use App\Constants\AgreementStatusConstants;
use App\Models\Agreement;
use App\Repositories\AgreementRepository;
use App\Repositories\AgreementStatusRepository;
use App\Repositories\AttachmentRepository;
use App\Repositories\OfferRepository;
use App\Repositories\UniversityRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AgreementService
{
    /**
     * @var AgreementRepository
     */
    private $agreementRepository;

    /**
     * @var AttachmentService
     */
    private $attachmentService;

    /**
     * @var UniversityRepository
     */
    private $universityRepository;

    /**
     * @var OfferRepository
     */
    private $offerRepository;

    /**
     * @var AgreementStatusRepository
     */
    private $agreementStatusRepository;

    /**
     * AgreementService constructor.
     *
     * @param AgreementRepository       $agreementRepository
     * @param AttachmentService         $attachmentService
     * @param UniversityRepository      $universityRepository
     * @param OfferRepository           $offerRepository
     * @param AgreementStatusRepository $agreementStatusRepository
     */
    public function __construct(
        AgreementRepository $agreementRepository,
        AttachmentService $attachmentService,
        UniversityRepository $universityRepository,
        OfferRepository $offerRepository,
        AgreementStatusRepository $agreementStatusRepository
    ) {
        $this->agreementRepository = $agreementRepository;
        $this->attachmentService = $attachmentService;
        $this->universityRepository = $universityRepository;
        $this->offerRepository = $offerRepository;
        $this->agreementStatusRepository = $agreementStatusRepository;
    }

    /**
     * @param string      $name
     * @param string      $dateFrom
     * @param string      $dateTo
     * @param string      $program
     * @param int         $companyId
     * @param int         $universityId
     * @param int         $universitySupervisorId
     * @param int         $placesNumber
     * @param string|null $schedule
     * @param string|null $content
     * @param int|null    $offerId
     * @param bool|null   $isActive
     * @param string|null $signingDate
     *
     * @return Agreement|null
     */
    public function createAgreement(
        string $name,
        string $dateFrom,
        string $dateTo,
        string $program,
        int $companyId,
        int $universityId,
        int $universitySupervisorId,
        int $placesNumber = 1,
        ?string $schedule = null,
        ?string $content = null,
        ?int $offerId = null,
        ?bool $isActive = false,
        ?string $signingDate = null,
        ?int $agreementStatusId = null
    ): ?Agreement {
        $agreementStatus = $agreementStatusId ?? $this->agreementStatusRepository->getStatusByName(AgreementStatusConstants::STATUS_NEW);

        $agreement = new Agreement();
        $agreement->name = $name;
        $agreement->slug = Str::slug($name . '-' . Str::random(5));
        $agreement->signing_date = $signingDate ?? null;
        $agreement->places_number = $placesNumber ?? null;
        $agreement->date_from = $dateFrom;
        $agreement->date_to = $dateTo;
        $agreement->program = $program;
        $agreement->schedule = $schedule;
        $agreement->content = $content;
        $agreement->company_id = $companyId;
        $agreement->university_id = $universityId;
        $agreement->university_supervisor_id = $universitySupervisorId;
        $agreement->agreement_status_id = $agreementStatus->id;
        $agreement->offer_id = $offerId ?? null;
        $agreement->user_id = Auth::id();
        $agreement->is_active = $isActive;
        $agreement->freshTimestamp();

        if ($agreement->save()) {
            return $agreement;
        }

        return null;
    }

    public function acceptAgreement($slug)
    {
        $status = $this->agreementStatusRepository->getStatusByName('accepted');
        $agreement = $this->agreementRepository->changeAgreementStatus($slug, $status->id);

        return $agreement ?? null;
    }

    public function rejectAgreement($slug)
    {
        $status = $this->agreementStatusRepository->getStatusByName('rejected');
        $agreement = $this->agreementRepository->changeAgreementStatus($slug, $status->id);

        return $agreement ?? null;
    }

    /**
     * @param $slug
     * @param $isActive
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function setAgreementActiveStatus($slug, $isActive)
    {
        $agreement = $this->agreementRepository->getAgreementBySlug($slug);

        if ($agreement !== null) {
            $agreement->is_active = $isActive;
            if ($agreement->save()) {
                return $agreement;
            }
        }

        return null;
    }

    public function deleteAgreement($slug): bool
    {
        $agreement = $this->agreementRepository->getAgreementBySlug($slug);

        return $agreement !== null && $agreement->delete();
    }
}
