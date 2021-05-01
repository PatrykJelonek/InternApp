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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AgreementService
{
    /**
     * @var AgreementRepository
     */
    private $agreementRepository;

    /**
     * AgreementService constructor.
     *
     * @param AgreementRepository $agreementRepository
     */
    public function __construct(AgreementRepository $agreementRepository)
    {
        $this->agreementRepository = $agreementRepository;
    }

    /**
     * @param array $data
     *
     * @return Agreement|null
     */
    public function createAgreement(array $data): ?Agreement
    {
        $agreement = new Agreement();

        $agreement->name = $data['name'];
        $agreement->slug = Str::slug($data['name']);
        $agreement->signing_date = $data['signingDate'] ?? null;
        $agreement->date_from = $data['dateFrom'];
        $agreement->date_to = $data['dateTo'];
        $agreement->program = $data['program'];
        $agreement->schedule = $data['schedule'];
        $agreement->content = $data['content'];
        $agreement->company_id = $data['companyId'];
        $agreement->university_id = $data['universityId'];
        $agreement->university_supervisor_id = $data['universitySupervisorId'];
        $agreement->offer_id = $data['offerId'];
        $agreement->user_id = $data['userId'] ?? Auth::id();
        $agreement->is_active = $data['isActive'] ?? false;
        $agreement->freshTimestamp();

        if($agreement->save()) {
            return $agreement;
        }

        return null;
    }
}
