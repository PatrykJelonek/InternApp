<?php
/**
 * Created by PhpStorm.
 * User: Patryk Jelonek (patryk)
 * Date: 01/05/2021
 * Time: 23:23
 */

namespace App\Services;

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
     * @param array $data
     *
     * @return Agreement|null
     */
    public function createAgreement(array $data): ?Agreement
    {
        DB::beginTransaction();

        $university = $this->universityRepository->one($data['universitySlug']);
        $this->offerRepository->updateOffer(
            ['placesNumber' => $data['offerPlacesNumber'] - $data['placesNumber']],
            $data['offerId']
        );

        $data['userId'] = Auth()->id();
        $data['universityId'] = $university->id;

        $agreement = $this->agreementRepository->create($data);

        if ($agreement !== null) {
            DB::commit();

            if (!empty($data['attachments'])) {
                $this->attachmentService->storeAgreementAttachments($data['attachments'], $agreement->id);
            }

            return $agreement;
        }

        DB::rollBack();
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
}
