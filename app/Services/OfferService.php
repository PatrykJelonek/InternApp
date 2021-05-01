<?php
/**
 * Created by PhpStorm.
 * User: Patryk Jelonek (patryk)
 * Date: 30/04/2021
 * Time: 20:28
 */

namespace App\Services;

use App\Repositories\CompanyRepository;
use App\Repositories\OfferRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
     * OfferService constructor.
     *
     * @param OfferRepository   $offerRepository
     * @param AttachmentService $attachmentService
     * @param CompanyRepository $companyRepository
     */
    public function __construct(OfferRepository $offerRepository, AttachmentService $attachmentService, CompanyRepository $companyRepository)
    {
        $this->offerRepository = $offerRepository;
        $this->attachmentService = $attachmentService;
        $this->companyRepository = $companyRepository;
    }

    public function createOffer(array $data)
    {
        DB::beginTransaction();

        $data = array_merge(['userId' => Auth()->id()], $data);

        $offer = $this->offerRepository->createOffer($data);

        if($offer !== null) {
            DB::commit();

            if(!empty($data['attachments'])) {
                foreach ($data['attachments'] as $attachment) {
                    $this->attachmentService->storeOfferAttachment($attachment, $offer->id);
                }
            }

            return $offer;
        }

        DB::rollBack();
    }
}
