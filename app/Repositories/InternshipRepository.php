<?php

namespace App\Repositories;

use App\Constants\RoleConstants;
use App\Models\Internship;
use App\Repositories\Interfaces\InternshipRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class InternshipRepository implements InternshipRepositoryInterface {

    /**
     * @param $id // InternshipId
     * @return mixed // Return specific internship
     */
    public function one($id)
    {
        $internship = null;

        if(Auth::user()->hasRole(RoleConstants::ROLE_ADMIN)) {
            $internship = Internship::find($id);
        } else {
            $internship = Internship::where('id', $id)
                ->where(function ($query) {
                    $query->where('university_supervisor_id', Auth::user()->id)
                        ->orWhere('company_supervisor_id', Auth::user()->id);
                })->with(['agreement.university','agreement.company'])->first();
        }

        return $internship;
    }

    public function all()
    {
        // TODO: Implement all() method.
    }

    public function getInternshipStudents($id)
    {
        return $this->one($id)->students;
    }
}
