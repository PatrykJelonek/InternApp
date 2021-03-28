<?php

namespace App\Repositories;

use App\Constants\RoleConstants;
use App\Models\Internship;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class UserRepository implements UserRepositoryInterface
{

    public function getInternships()
    {
        $currentUserId = Auth::user()->id;
        $internships = null;

        if (Auth::user()->hasRole([RoleConstants::ROLE_UNIVERSITY_SUPERVISOR, RoleConstants::ROLE_COMPANY_SUPERVISOR])) {
            $internships = Internship::where('university_supervisor_id', $currentUserId)
                ->orWhere('company_supervisor_id', $currentUserId)
                ->with('agreement.company')
                ->get();
        }

        if (Auth::user()->hasRole(RoleConstants::ROLE_STUDENT)) {
            $student = User::find($currentUserId)->student()->with(['internships','internships.agreement.company','internships.agreement.offer'])->first();

            $internships = $student->internships;
        }

//        if (!Auth::user()->hasRole([RoleConstants::ROLE_UNIVERSITY_SUPERVISOR, RoleConstants::ROLE_COMPANY_SUPERVISOR, RoleConstants::ROLE_STUDENT])) {
//            $internships = User::find($currentUserId)->universities()->agreements()->internships()->get();
//        }

        return $internships;
    }

    public function getUniversities()
    {
        $universities = auth()->user()->universities;

        if(!empty($universities)) {
            return $universities;
        }

        return null;
    }
}
