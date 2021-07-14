<?php
/**
 * Created by PhpStorm.
 * User: Patryk Jelonek (patryk)
 * Date: 14/03/2021
 * Time: 20:37
 */

namespace App\Repositories;

use App\Constants\RoleConstants;
use App\Models\Agreement;
use App\Models\Faculty;
use App\Models\Internship;
use App\Models\Questionnaire;
use App\Models\University;
use App\Models\User;
use App\Repositories\Interfaces\UniversityRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UniversityRepository implements UniversityRepositoryInterface
{

    /**
     * @param string $slug
     *
     * @return mixed
     */
    public function getUniversityBySlug(string $slug)
    {
        $university = University::where('slug', $slug)->with(['type', 'city', 'faculties'])->first();

        if (!empty($university)) {
            return $university;
        }

        return null;
    }

    public function all()
    {
        return University::all();
    }

    public function create(array $data)
    {
        DB::transaction(
            function () use ($data) {
                $university = new University();
                $university->name = $data['name'];
                $university->university_type_id = $data['university_type_id'];
                $university->city_id = $data['city_id'];
                $university->street = $data['street'];
                $university->street_number = $data['street_number'];
                $university->email = $data['email'];
                $university->phone = $data['phone'];
                $university->website = $data['website'];
                $university->access_code = $data['access_code'];
                $university->slug = Str::slug($data['name']);
                $university->created_at = Carbon::today();
                $university->updated_at = Carbon::today();
                $university->save();

                return $university;
            }
        );

        return null;
    }

    public function update(array $data)
    {
        DB::transaction(
            function () use ($data) {
                $university = new University();
                $university->name = $data['name'];
                $university->university_type_id = $data['university_type_id'];
                $university->city_id = $data['city_id'];
                $university->street = $data['street'];
                $university->street_number = $data['street_number'];
                $university->email = $data['email'];
                $university->phone = $data['phone'];
                $university->website = $data['website'];
                $university->access_code = $data['access_code'];
                $university->slug = Str::slug($data['name']);
                $university->created_at = Carbon::today();
                $university->updated_at = Carbon::today();
                $university->save();

                return $university;
            }
        );

        return null;
    }

    public function delete(int $id): bool
    {
        $university = University::find($id);

        if ($university->delete()) {
            return true;
        }

        return false;
    }

    public function getWorkers(string $slug)
    {
        return User::with('roles','universities')->whereHas(
            'universities',
            function (Builder $query) use ($slug) {
                $query->where('slug', $slug);
            }
        )->whereHas(
            'roles',
            function (Builder $query) {
                $query->whereIn(
                    'name',
                    [
                        RoleConstants::ROLE_UNIVERSITY_SUPERVISOR,
                        RoleConstants::ROLE_UNIVERSITY_WORKER,
                        RoleConstants::ROLE_UNIVERSITY_OWNER,
                    ]
                );
            }
        )->get();
    }

    public function getStudents(string $slug)
    {
        return User::with(['roles', 'student', 'student.specialization', 'student.internships'])->whereHas(
            'universities',
            function (Builder $query) use ($slug) {
                $query->where('slug', $slug);
            }
        )->whereHas('student')
            ->whereHas(
                'roles',
                function (Builder $query) {
                    $query->whereIn(
                        'name',
                        [
                            RoleConstants::ROLE_STUDENT,
                        ]
                    );
                }
            )->get();
    }

    public function getAgreements(string $slug)
    {
        return Agreement::with(['offer', 'company', 'supervisor', 'offer.supervisor'])->whereHas(
            'university',
            function (Builder $query) use ($slug) {
                $query->where('slug', $slug);
            }
        )->orderByDesc('created_at')->get();
    }

    public function getOffers(string $slug)
    {
        return Agreement::with(['offer', 'company', 'supervisor', 'offer.supervisor'])
            ->where('is_active', '=', true)
            ->whereHas(
                'university',
                function (Builder $query) use ($slug) {
                    $query->where('slug', $slug);
                }
            )->get();
    }

    public function getInternships(string $slug)
    {
        return Internship::with(
            ['offer', 'agreement', 'universitySupervisor', 'companySupervisor', 'status']
        )->whereHas(
            'agreement.university',
            function (Builder $query) use ($slug) {
                $query->where('slug', $slug);
            }
        )->get();
    }

    public function getSpecializations(string $slug)
    {
        //TODO: Make some code
    }

    public function getFaculties(string $slug)
    {
        return Faculty::with(['fields', 'fields.specializations'])->whereHas(
            'universities',
            function (Builder $query) use ($slug) {
                $query->where('slug', $slug);
            }
        )->get();
    }

    public function getQuestionnaires(string $slug)
    {
        return Questionnaire::with(['questions', 'university'])->whereHas(
            'university',
            function (Builder $query) use ($slug) {
                $query->where(['slug' => $slug]);
            }
        )->get();
    }
}
