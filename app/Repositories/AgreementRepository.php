<?php
/**
 * Created by PhpStorm.
 * User: Patryk Jelonek (patryk)
 * Date: 05/04/2021
 * Time: 19:05
 */

namespace App\Repositories;

use App\Models\Agreement;
use App\Repositories\Interfaces\AgreementRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;

class AgreementRepository implements AgreementRepositoryInterface
{
    private $with = ['offer.category', 'university', 'company', 'status','company.city', 'supervisor', 'attachments'];

    public function getAgreementBySlug(string $slug)
    {
        return Agreement::with($this->with)->where(['slug' => $slug])->first();
    }

    public function all(bool $onlyActive)
    {
        $agreements = Agreement::with($this->with);

        if ($onlyActive) {
            $agreements->where('is_active', '=', true);
        }

        return $agreements->get();
    }

    /**
     * @param array $data
     *
     * @return Agreement|null
     */
    public function create(array $data): ?Agreement
    {
        $agreement = new Agreement();

        $agreement->name = $data['name'];
        $agreement->slug = Str::slug($data['name']) . '-' . Str::random(5);
        $agreement->signing_date = $data['signingDate'] ?? null;
        $agreement->date_from = $data['dateFrom'];
        $agreement->date_to = $data['dateTo'];
        $agreement->program = $data['program'];
        $agreement->schedule = $data['schedule'];
        $agreement->content = $data['content'];
        $agreement->company_id = $data['companyId'];
        $agreement->university_id = $data['universityId'];
        $agreement->university_supervisor_id = $data['universitySupervisorId'];
        $agreement->agreement_status_id = $data['agreementStatusId'];
        $agreement->offer_id = $data['offerId'];
        $agreement->user_id = $data['userId'] ?? Auth::id();
        $agreement->is_active = $data['isActive'] ?? false;
        $agreement->freshTimestamp();

        if ($agreement->save()) {
            return $agreement;
        }

        return null;
    }

    public function edit(string $slug)
    {
        // TODO: Implement edit() method.
    }

    public function delete(string $slug)
    {
        // TODO: Implement delete() method.
    }

    public function changeAgreementStatus(string $slug, int $statusId)
    {
        $agreement = Agreement::where(['slug' => $slug])->first();
        $agreement->agreement_status_id = $statusId;

        if($agreement->update()) {
            return $agreement;
        }

        return null;
    }

    public function getAgreementByInternshipId(int $internshipId)
    {
        return Agreement::whereHas('internships', function (Builder $query) use ($internshipId) {
            $query->where(['id' => $internshipId]);
        })->first();
    }
}
