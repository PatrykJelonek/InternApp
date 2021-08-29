<?php

namespace App\Repositories;

use App\Constants\RoleConstants;
use App\Http\Resources\Collections\MessageCollection;
use App\Models\Internship;
use App\Models\InternshipStatus;
use App\Models\Message;
use App\Models\User;
use App\Models\UserStatus;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;

class UserRepository implements UserRepositoryInterface
{
    public function getInternships(int $userId, array $status = null)
    {
        $internships = [];
        $user = User::find($userId);

        if ($user->hasRole(
            [RoleConstants::ROLE_UNIVERSITY_SUPERVISOR, RoleConstants::ROLE_COMPANY_SUPERVISOR]
        )) {
            $model = Internship::where(
                function (Builder $query) use ($userId) {
                    $query->where('university_supervisor_id', $userId)->orWhere('company_supervisor_id', $userId);
                }
            )->with(['agreement.company', 'agreement.university', 'offer', 'status']);

            if (!empty($status[0])) {
                $model->whereHas(
                    'status',
                    function (Builder $query) use ($status) {
                        if (!empty($status)) {
                            $query->where(['name' => $status]);
                        }
                    }
                );
            }

            $internships = $model->get();
        }

        if ($user->hasRole(RoleConstants::ROLE_STUDENT)) {
            $model = Internship::whereHas(
                'students',
                function (Builder $query) use ($userId) {
                    $query->where(['user_id' => $userId]);
                }
            )->with(['agreement','agreement.company', 'agreement.university', 'offer', 'status']);

            if (!empty($status[0])) {
                $model->whereHas(
                    'status',
                    function (Builder $query) use ($status) {
                        if (!empty($status)) {
                            $query->where(['name' => $status]);
                        }
                    }
                );
            }

            $internships = $model->get();
        }

//        if (!Auth::user()->hasRole([RoleConstants::ROLE_UNIVERSITY_SUPERVISOR, RoleConstants::ROLE_COMPANY_SUPERVISOR, RoleConstants::ROLE_STUDENT])) {
//            $internships = User::find($currentUserId)->universities()->agreements()->internships()->get();
//        }

        return $internships;
    }

    public function getUniversities()
    {
        $universities = auth()->user()->universities;

        if (!empty($universities)) {
            return $universities;
        }

        return null;
    }

    public function getUniversitiesWithRoles()
    {
        $universities = auth()->user()->universitiesWithRoles;

        if (!empty($universities)) {
            return $universities;
        }

        return null;
    }

    public function getCompanies()
    {
        $companies = auth()->user()->companies;

        if (!empty($companies)) {
            return $companies;
        }

        return null;
    }

    public function getMessages(int $userId)
    {
        $messages = Message::with(['sender', 'receiver',])->whereHas(
            'sender',
            function (Builder $query) use ($userId) {
                $query->where(['id' => $userId]);
            }
        )->orWhereHas(
            'receiver',
            function (Builder $query) use ($userId) {
                $query->where(['id' => $userId]);
            }
        )->orderByDesc('created_at')->get();

        $messagesCollection = new MessageCollection($messages);

        return $messagesCollection->toArray(new Request());
    }

    public function getUserById(int $userId)
    {
        return User::with(['universities', 'companies'])->find($userId);
    }

    public function getUserCompanyRoles(int $userId, $companySlug)
    {
        $userCompany = User::with(['companies'])->find($userId)->companies()->where(['slug' => $companySlug])->first();
        $pivotId = $userCompany->pivot->id;
        # TODO: Do dokończenia
    }

    public function getUserUniversityRoles(int $userId, $universitySlug)
    {
        $userUniversity = User::with(['universities'])->find($userId)->universities()->where(['slug' => $universitySlug]
        )->first();
        $pivotId = $userUniversity->pivot->id;
        # TODO: Do dokończenia
    }

    public function getUserStatusByName(string $name)
    {
        return UserStatus::where(['name' => $name])->first();
    }

    public function getUserByActivationToken(string $activationToken)
    {
        return User::where(['activation_token' => $activationToken])->first();
    }
}
