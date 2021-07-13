<?php
/**
 * Created by PhpStorm.
 * User: Patryk Jelonek (patryk)
 * Date: 02/05/2021
 * Time: 20:29
 */

namespace App\Services;

use App\Models\Agreement;
use App\Models\Internship;
use App\Models\Student;
use App\Notifications\InternshipCreated;
use App\Repositories\InternshipRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class InternshipService
{
    /**
     * @var InternshipRepository
     */
    private $internshipRepository;

    /**
     * InternshipService constructor.
     *
     * @param InternshipRepository $internshipRepository
     */
    public function __construct(InternshipRepository $internshipRepository)
    {
        $this->internshipRepository = $internshipRepository;
    }

    public function applyToInternship($data)
    {
        DB::beginTransaction();
        $internship = Internship::where(
            ['offer_id' => $data['offerId'], 'agreement_id' => $data['agreementId']]
        )->first();
        $agreement = Agreement::find($data['agreementId']);


        if ($agreement->places_number < 1) {
            return null;
        }

        if (!isset($internship)) {
            $internship = $this->internshipRepository->create(
                $data['userId'],
                $data['offerId'],
                $data['agreementId'],
                $data['companySupervisorId'],
                $data['universitySupervisorId']
            );
        }

        if ($internship !== null) {
            $student = Student::with(['user'])->where(['user_id' => $data['userId']])->first();

            if ($student !== null) {
                $internship->students()->attach($student->id);

                $agreement->places_number--;

                if($agreement->update()) {
                    DB::commit();

                    Notification::send(
                        [$internship->universitySupervisor->email],
                        new InternshipCreated($internship, $student->user)
                    );

                    return $internship;
                }
            }

            DB::rollBack();
        } else {
            DB::rollBack();
        }

        return null;
    }

    public function changeInternshipStatus(int $internshipId, int $statusId)
    {
        $internship = $this->internshipRepository->getInternship($internshipId);
        $internship->internship_status_id = $statusId;

        if ($internship->save()) {
            return $internship;
        }

        return null;
    }
}
