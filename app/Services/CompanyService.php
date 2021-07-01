<?php
/**
 * Created by PhpStorm.
 * User: Patryk Jelonek (patryk)
 * Date: 01/07/2021
 * Time: 21:44
 */

namespace App\Services;

use App\Models\Company;
use App\Models\User;
use App\Repositories\CompanyRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CompanyService
{
    /**
     * @var CompanyRepository
     */
    private $repository;

    /**
     * CompanyService constructor.
     *
     * @param CompanyRepository $repository
     */
    public function __construct(CompanyRepository $repository)
    {
        $this->repository = $repository;
    }

    public function updateCompanyData(
        string $slug,
        string $email = null,
        string $phone = null,
        string $website = null,
        string $description = null
    ) {
        $company = $this->repository->getCompanyBySlug($slug);

        if ($company !== null) {
            $company->email = $email ?? $company->email;
            $company->phone = $phone ?? $company->phone;
            $company->website = $website ?? $company->website;
            $company->description = $description ?? $company->description;
            $company->updateTimestamps();

            if ($company->update()) {
                Log::channel('user')->info(
                    'Użytkownik zmienił dane firmy!',
                    ['user_id' => Auth::id(), 'company_id' => $company->id]
                );
                return $company;
            }
        }
        Log::channel('user')->error(
            'Wystąpił problem podczas aktualizacji danych firmy!',
            [
                'user_id' => Auth::id(),
                'company_id' => $company->id ?? null,
                'data' => [
                    'slug' => $slug,
                    'email' => $email,
                    'phone' => $phone,
                    'website' => $website,
                    'description' => $description,
                ],
            ]
        );
        return null;
    }

    public function deleteCompanyWokrer(string $slug, string $userId)
    {
        $user = User::with(['companies'])->where(['id' => $userId])->whereHas(
            'companies',
            function (Builder $query) use ($slug) {
                $query->where(['slug' => $slug]);
            }
        )->first();

        $company = $this->repository->getCompanyBySlug($slug);

        if ($user !== null && $company !== null) {
            $user->companies()->detach([$company->id]);
            Log::channel('user')->info(
                'Użytkownik został usunięty z firmy!',
                [
                    'user_id' => Auth::id(),
                    'company_id' => $company->id,
                    'deleted_user_id' => $user->id,
                ]
            );
            return true;
        }

        Log::channel('user')->error(
            'Wystąpił problem z usunięciem użytkownika z firmy!',
            [
                'user_id' => Auth::id(),
                'data' => [
                    'slug' => $slug,
                    'user_id' => $userId,
                ],
            ]
        );

        return false;
    }

    public function acceptCompanyWorker(string $slug, string $userId)
    {
        $user = User::with(['companies'])->where(['id' => $userId])->whereHas(
            'companies',
            function (Builder $query) use ($slug) {
                $query->where(['slug' => $slug]);
            }
        )->first();

        $company = $this->repository->getCompanyBySlug($slug);

        if ($user !== null && $company !== null) {
            if ($user->companies()->updateExistingPivot(
                $company->id,
                [
                    'active' => true,
                ]
            )) {
                Log::channel('user')->info(
                    'Użytkownik został zaakceptowany jako pracownik firmy!',
                    [
                        'user_id' => Auth::id(),
                        'company_id' => $company->id,
                        'data' => [
                            'slug' => $slug,
                            'userId' => $userId,
                        ],
                    ]
                );
            }
        }

        Log::channel('user')->error(
            'Wystąpił problem z akceptacją użytkownika jako pracownika firmy!',
            [
                'user_id' => Auth::id(),
                'data' => [
                    'slug' => $slug,
                    'user_id' => $userId,
                ],
            ]
        );

        return false;
    }
}
