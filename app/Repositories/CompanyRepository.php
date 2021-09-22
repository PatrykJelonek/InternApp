<?php
/**
 * Created by PhpStorm.
 * User: Patryk Jelonek (patryk)
 * Date: 14/03/2021
 * Time: 20:39
 */

namespace App\Repositories;

use App\Constants\RoleConstants;
use App\Models\Agreement;
use App\Models\Company;
use App\Models\Offer;
use App\Models\Questionnaire;
use App\Models\University;
use App\Models\User;
use App\Models\UserCompany;
use App\Models\UserCompanyRole;
use App\Models\UserUniversity;
use App\Models\UserUniversityRole;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

use function Clue\StreamFilter\fun;

class CompanyRepository implements CompanyRepositoryInterface
{
    public function getCompanyById(int $id)
    {
        return Company::find($id);
    }

    public function getCompanyBySlug(string $slug)
    {
        return Company::with(['city', 'category', 'user'])
            ->where(['slug' => $slug])
            ->first();
    }

    public function getCompanies(bool $withNotAccepted = false, bool $withDrafts = false)
    {
        $company = Company::with(['city', 'category']);

        if (!$withNotAccepted) {
            $company->where(['verified' => true]);
        }

        if (!$withDrafts) {
            $company->where(['draft' => false]);
        }

        return $company->get();
    }

    public function createCompany(array $data)
    {
        $company = new Company();
        $company->name = $data['name'];
        $company->city = $data['cityId'];
        $company->street = $data['street'];
        $company->street_number = $data['street_number'];
        $company->email = $data['email'];
        $company->phone = $data['phone'] ?? null;
        $company->website = $data['website'] ?? null;
        $company->description = $data['description'];
        $company->slug = Str::slug($data['name']);
        $company->access_code = $this->generateAccessCode();
        $company->company_category_id = $data['companyCategoryId'];
        $company->accepted = false;
        $company->draft = $data['draft'] ?? false;
        $company->created_at = Carbon::today();
        $company->updated_at = Carbon::today();

        if ($company->save()) {
            return $company;
        }

        return null;
    }


    public function updateCompany(array $data)
    {
        // TODO: Implement updateCompany() method.
    }

    public function deleteCompanyById(int $id)
    {
        // TODO: Implement deleteCompanyById() method.
    }

    public function deleteCompanyBySlug(string $slug)
    {
        // TODO: Implement deleteCompanyBySlug() method.
    }

    public function generateAccessCode()
    {
        do {
            $randomAccessCode = Str::upper(Str::random(8));
        } while (count(Company::where('access_code', $randomAccessCode)->get()) > 0);

        return $randomAccessCode;
    }

    public function getCompanyOffers(
        string $slug,
        ?array $categories = null,
        ?array $statuses = null,
        ?int $limit = null
    ) {
        $company = $this->getCompanyBySlug($slug);

        if ($company === null) {
            return null;
        }

        $companyOffers = Offer::with(['category', 'status', 'supervisor'])->where(
            ['company_id' => $company->id]
        );

        if ($statuses !== null) {
            $companyOffers->whereHas(
                'status',
                function (Builder $query) use ($statuses) {
                    $query->where('name', $statuses);
                }
            );
        }

        if ($categories !== null) {
            $companyOffers->whereHas(
                'category',
                function (Builder $query) use ($categories) {
                    $query->where('name', $categories);
                }
            );
        }

        if ($limit !== null) {
            $companyOffers->limit($limit);
        }

        return $companyOffers->orderByDesc('id')->get();
    }

    public function getCompanyWorkers(string $slug, ?array $roles = null, ?array $statuses = null, ?int $limit = null)
    {
        return User::with(
            [
                'companiesWithRoles' => function ($query) use ($slug) {
                    $query->whereHas('company', function ($query) use ($slug) {
                        $query->where(['slug' => $slug]);
                    });
                },
            ]
        )->whereHas(
            'companies',
            function (Builder $query) use ($slug) {
                $query->where('slug', $slug);
            }
        )->get();
    }

    public function getCompanyAgreements(string $slug, ?bool $isActive = null)
    {
        $agreements = Agreement::with(
            ['university', 'supervisor', 'author', 'internships', 'offer', 'status']
        )->whereHas(
            'company',
            function (Builder $query) use ($slug) {
                $query->where(['slug' => $slug]);
            }
        );

        if ($isActive !== null) {
            $agreements->where(['isActive', $isActive]);
        }

        return $agreements->get();
    }

    public function getCompanyQuestionnaires(string $slug)
    {
        return Questionnaire::with(['questions', 'company', 'user'])->whereHas(
            'company',
            function (Builder $query) use ($slug) {
                $query->where(['slug' => $slug]);
            }
        )->get();
    }

    public function getUserCompany(int $userId, int $companyId)
    {
        return UserCompany::where(
            [
                'user_id' => $userId,
                'company_id' => $companyId,
            ]
        )->first();
    }

    public function getUsersCompaniesRoles(int $userId, int $companyId): ?UserCompanyRole
    {
        $userCompany = $this->getUserCompany($userId, $companyId);

        if (is_null($userCompany)) {
            return null;
        }

        /** @var UserCompanyRole $userCompany */
        return UserCompanyRole::where(['user_company_id' => $userCompany->id])->first();
    }

    public function getCompaniesToVerification()
    {
        return Company::with(['city', 'type'])
            ->where(['verified' => false])
            ->get();
    }

    public function getAllVerifiedCompanies()
    {
        return Company::with(['city','type','user'])
            ->where(['verified' => true])
            ->get();
    }
}
