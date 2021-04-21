<?php

namespace App\Repositories;

use App\Models\Company;
use App\Models\JournalEntry;
use App\Models\Student;
use App\Models\StudentJournalEntry;
use App\Models\User;
use App\Notifications\JournalEntryCreated;
use App\Repositories\Interfaces\StudentRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class StudentRepository implements StudentRepositoryInterface
{
    /**
     * @param $studentIndex
     *
     * @return mixed
     */
    public function one($studentIndex)
    {
        return Student::where('student_index', $studentIndex)->first();
    }

    public function all()
    {
        // TODO: Implement all() method.
    }

    /**
     * @param $studentIndex
     *
     * @return mixed
     */
    public function getStudentJournalEntries($studentIndex)
    {
        $student = $this->one($studentIndex);

        if (!empty($student)) {
            return $student->journalEntries()->orderByDesc('date')->get();
        }

        return null;
    }

    /**
     * @param $studentIndex
     *
     * @return mixed
     */
    public function getStudentTasks($studentIndex)
    {
        $student = $this->one($studentIndex);

        if (!empty($student)) {
            return $student->tasks()->orderByDesc('created_at')->get();
        }

        return null;
    }

    /**
     * @param int    $internshipId
     * @param string $content
     * @param array  $studentsIds
     * @param bool   $accepted
     * @param string $date
     *
     * @return JournalEntry|null
     */
    public function storeStudentJournalEntry(
        int $internshipId,
        string $content,
        array $studentsIds,
        bool $accepted,
        string $date
    ): ?JournalEntry {
        DB::transaction(
            function () use ($internshipId, $content, $studentsIds, $accepted, $date) {
                $journalEntry = new JournalEntry();
                $journalEntry->internship_id = $internshipId;
                $journalEntry->content = $content;
                $journalEntry->user_id = Auth::user()->id;
                $journalEntry->accepted = $accepted;
                $journalEntry->date = $date;
                $journalEntry->created_at = Carbon::today();
                $journalEntry->updated_at = Carbon::today();
                $journalEntry->save();

                foreach ($studentsIds as $studentId) {
                    $studentJournalEntry = new StudentJournalEntry();
                    $studentJournalEntry->journal_entry_id = $journalEntry->id;
                    $studentJournalEntry->student_id = $studentId;
                    $studentJournalEntry->accepted = false;
                    $studentJournalEntry->created_at = Carbon::today();
                    $studentJournalEntry->updated_at = Carbon::today();

                    if ($studentJournalEntry->save()) {
                        Notification::send($studentJournalEntry->student->user, new JournalEntryCreated($journalEntry));
                    }
                }

                return $journalEntry;
            }
        );

        return null;
    }

    public function update(array $data)
    {
        // TODO: Implement update() method.
    }

    public function delete(int $id)
    {
        // TODO: Implement delete() method.
    }

    /**
     * @param int $userId
     *
     * @return array|null
     */
    public function getAvailableInternshipOffers(int $userId): ?array
    {
        $userUniversities = User::with(['universities.agreements'])->find($userId)->universities;

        if(!empty($userUniversities)) {
            $agreements = [];

            foreach ($userUniversities as $university) {
                $agreements[] =  $university->agreements()->with(['offer','offer.category','offer.company.city'])->where(function (Builder $query) {
                    $query->where('is_active', true)->where('date_from','>', Carbon::today()->subDays(config('global.acceptableDifferenceDays'))->toDateString());
                })->get()->toArray();
            }

            if (!empty($agreements)) {
                return array_merge(...$agreements);
            }
        }

        return null;
    }

    public function createStudentOwnInternship($data)
    {
//        company: {
//        id: null,
//                    name: null,
//                    street: null,
//                    streetNumber: null,
//                    cityPostCode: null,
//                    cityName: null,
//                    cityId: null,
//                    email: null,
//                    phone: null,
//                    website: null,
//                    categoryId: null,
//                },
//        offer: {
//        companyId: null,
//                    universityId: null,
//                    name: null,
//                    program: null,
//                    schedule: null,
//                    categoryId: null,
//                    attachments: null
//                },
//        agreement: {
//        dateFrom: null,
//                    dateTo: null,
//                }
        DB::beginTransaction();

        if(!empty($data['company']['id'])) {
            $company = Company::find($data['company']['id']);
        } else {
            $company = new Company();
            $company->name = $data['company'];
            $company->street = $data['company'];
            $company->street_number = $data['company'];
            $company->email = $data['company'];
            $company->phone = $data['company'];
            $company->website = $data['company'];
            $company->description = $data['company'];
            $company->slug = $data['company'];
            $company->access_code = $data['company'];
            $company->company_category_id = $data['company'];
            $company->created_at = Carbon::today();
            $company->updated_at = Carbon::today();

        }

        dd($data);
    }
}
