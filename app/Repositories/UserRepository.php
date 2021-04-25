<?php

namespace App\Repositories;

use App\Constants\RoleConstants;
use App\Models\Internship;
use App\Models\InternshipStatus;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class UserRepository implements UserRepositoryInterface
{
    public function getInternships(int $userId, array $status = null)
    {
        $internships = null;
        $user = User::find($userId);

        if ($user->hasRole(
            [RoleConstants::ROLE_UNIVERSITY_SUPERVISOR, RoleConstants::ROLE_COMPANY_SUPERVISOR]
        )) {
            $internships = Internship::whereHas(
                'status',
                function (Builder $query) use ($status) {
                    if (!empty($status)) {
                        $query->where(['name' => $status]);
                    }
                }
            )->where(
                function (Builder $query) use ($userId) {
                    $query->where('university_supervisor_id', $userId)->orWhere('company_supervisor_id', $userId);
                }
            )->with(['agreement.company','offer','status'])->get();
        }

        if ($user->hasRole(RoleConstants::ROLE_STUDENT)) {
            $internships = Internship::whereHas(
                'status',
                function (Builder $query) use ($status) {
                    if (!empty($status)) {
                        $query->where(['name' => $status]);
                    }
                }
            )->whereHas(
                'students',
                function (Builder $query) use ($userId) {
                    $query->where(['user_id' => $userId]);
                }
            )->with(['agreement.company','offer','status'])
                ->get();
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

    public function getCompanies()
    {
        $companies = auth()->user()->companies;

        if (!empty($companies)) {
            return $companies;
        }

        return null;
    }
}
