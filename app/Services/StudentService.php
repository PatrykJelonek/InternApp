<?php
/**
 * Created by PhpStorm.
 * User: Patryk Jelonek (patryk)
 * Date: 23/04/2021
 * Time: 08:36
 */

namespace App\Services;

use App\Constants\OfferStatusConstants;
use App\Models\Offer;
use App\Repositories\AttachmentRepository;
use App\Repositories\CityRepository;
use App\Repositories\CompanyRepository;
use App\Repositories\OfferRepository;
use App\Repositories\OfferStatusRepository;
use App\Repositories\StudentRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentService
{
    /**
     * @var StudentRepository
     */
    private $studentRepository;

    /**
     * @var CompanyRepository
     */
    private $companyRepository;

    /**
     * @var OfferRepository
     */
    private $offerRepository;

    /**
     * @var OfferStatusRepository
     */
    private $offerStatusRepository;

    /**
     * @var AttachmentRepository
     */
    private $attachmentRepository;

    /**
     * @var CityRepository
     */
    private $cityRepository;

    /**
     * @var AttachmentService
     */
    private $attachmentService;

    /**
     * StudentService constructor.
     *
     * @param CompanyRepository     $companyRepository
     * @param OfferRepository       $offerRepository
     * @param OfferStatusRepository $offerStatusRepository
     * @param CityRepository        $cityRepository
     * @param AttachmentService     $attachmentService
     */
    public function __construct(
        CompanyRepository $companyRepository,
        OfferRepository $offerRepository,
        OfferStatusRepository $offerStatusRepository,
        CityRepository $cityRepository,
        AttachmentService $attachmentService
    ) {
        $this->companyRepository = $companyRepository;
        $this->offerRepository = $offerRepository;
        $this->offerStatusRepository = $offerStatusRepository;
        $this->cityRepository = $cityRepository;
        $this->attachmentService = $attachmentService;
    }

    /**
     * @param array $data
     *
     * @return Offer
     */
    public function createStudentOwnInternship(array $data): ?Offer
    {
        DB::beginTransaction();
        try {
            if (empty($data['company']['id'])) {
                if (empty($data['company']['city']['id'])) {
                    $city = $this->cityRepository->createCity($data['company']['city']);

                    if ($city) {
                        $data['company'] = array_merge(['cityId' => $city->id], $data['company']);
                    }
                }

                $company = $this->companyRepository->createCompany($data['company']);

                if ($company) {
                    $data['offer'] = array_merge(['companyId' => $company->id], $data['ofer']);
                }
            } else {
                $data['offer'] = array_merge(['companyId' => $data['company']['id']], $data['offer']);
            }

            $data['offer'] = array_merge(['userId' => Auth::user()->id], $data['offer']);
            $data['offer'] = array_merge(
                [
                    'offerStatusId' => $this->offerStatusRepository->getOfferStatusByName(
                        OfferStatusConstants::STATUS_STUDENT_NEW
                    )->toArray()['id'],
                ],
                $data['offer']
            );

            $offer = $this->offerRepository->createOffer($data['offer']);
            if ($offer) {
                DB::commit();
                if (!empty($data['offer']['attachment'])) {
                    $this->attachmentService->storeOfferAttachment($data['offer']['attachment'], $offer->id);
                }
                return $offer;
            } else {
                DB::rollBack();
                return null;
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            clock()->info(
                'Wystąpił błąd',
                [
                    'method' => 'StudentController::createStudentOwnInternship',
                    'dump' => $exception,
                ]
            );
            return null;
        }
    }
}