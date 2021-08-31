<?php

namespace App\Repositories;

use App\Constants\InternshipStatusConstants;
use App\Constants\RoleConstants;
use App\Models\Internship;
use App\Models\InternshipStatus;
use App\Models\InternshipStudent;
use App\Repositories\Interfaces\InternshipRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class InternshipRepository implements InternshipRepositoryInterface
{

    /**
     * @param $id // InternshipId
     *
     * @return mixed // Return specific internship
     */
    public function getInternship($id)
    {
        $with = [
            'agreement.university.city',
            'agreement.company.city',
            'universitySupervisor',
            'companySupervisor',
            'status',
        ];

        $internship = Internship::where('id', $id)->with($with)->first();

        return $internship ?? null;
    }

    public function getInternshipByAgreementId(int $agreementId)
    {
        $internship = Internship::where(['agreement_id' => $agreementId])->with(
            [
                'agreement.university.city',
                'agreement.company.city',
                'universitySupervisor',
                'companySupervisor',
                'status',
            ]
        )->first();

        return $internship ?? null;
    }

    public function getInternships()
    {
        // TODO: Implement all() method.
    }

    public function getInternshipStudents($id)
    {
        return $this->getInternship($id)->students;
    }

    public function create(
        int $userId,
        int $offerId,
        int $agreementId,
        int $companySupervisorId,
        int $universitySupervisorId
    ) {
        $internshipStatus = InternshipStatus::select(['id'])->where(
            ['name' => InternshipStatusConstants::STATUS_NEW]
        )->first();

        $internship = new Internship();
        $internship->offer_id = $offerId;
        $internship->agreement_id = $agreementId;
        $internship->company_supervisor_id = $companySupervisorId;
        $internship->university_supervisor_id = $universitySupervisorId;
        $internship->internship_status_id = $internshipStatus->id;
        $internship->freshTimestamp();


        if ($internship->save()) {
            return $internship;
        }

        return null;
    }

    public function getInternshipStatuses()
    {
        return InternshipStatus::all();
    }

    public function getInternshipStudentByIndex(int $internshipId, string $studentIndex)
    {
        return InternshipStudent::with(['student.user'])
            ->where(['internship_id' => $internshipId])
            ->whereHas(
            'student',
            function (Builder $query) use ($studentIndex) {
                $query->where(['student_index' => $studentIndex]);
            }
        )->first();
    }

    public function getInternshipStatusByName(string $internshipStatusName)
    {
        return InternshipStatus::where(['name' => $internshipStatusName])->first();
    }
}
