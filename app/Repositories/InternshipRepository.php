<?php

namespace App\Repositories;

use App\Constants\InternshipStatusConstants;
use App\Constants\RoleConstants;
use App\Models\Internship;
use App\Models\InternshipStatus;
use App\Models\Offer;
use App\Models\Student;
use App\Notifications\InternshipCreated;
use App\Repositories\Interfaces\InternshipRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

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

    public function create(int $userId, int $offerId, int $agreementId, int $companySupervisorId, int $universitySupervisorId)
    {
        DB::beginTransaction();

        $offer = Offer::find($offerId);

        if ($offer->places_number > 0) {
            $internship = new Internship();
            $student = Student::with(['user'])->where(['user_id' => $userId])->first();
            $internshipStatus = InternshipStatus::select(['id'])->where(['name' => InternshipStatusConstants::STATUS_NEW])->first();

            $internship->offer_id = $offerId;
            $internship->agreement_id = $agreementId;
            $internship->company_supervisor_id = $companySupervisorId;
            $internship->university_supervisor_id = $universitySupervisorId;
            $internship->internship_status_id = $internshipStatus->id;
            $internship->updated_at = Carbon::today();
            $internship->created_at = Carbon::today();

            $offer->places_number--;

            if($offer->save() && $internship->save()) {
                $internship->students()->attach($student->id);
                Notification::send([$internship->universitySupervisor->email], new InternshipCreated($internship, $student->user));

                DB::commit();
                return $internship;
            }

            DB::rollBack();
        }

        return [];
    }
}
