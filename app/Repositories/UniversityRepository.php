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
use App\Models\Internship;
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
    public function one(string $slug)
    {
        $university = University::where('slug', $slug)->with(['type', 'city'])->first();

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
        return User::with('roles')->whereHas(
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
                        RoleConstants::ROLE_DEANERY_WORKER,
                    ]
                );
            }
        )->get();
    }

    public function getStudents(string $slug)
    {
        return User::with(['roles', 'student','student.specialization','student.internships'])->whereHas(
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
        return Agreement::with(['offer'])->whereHas(
            'university',
            function (Builder $query) use ($slug) {
                $query->where('slug', $slug);
            }
        )->get();
    }

    public function getInternships(string $slug)
    {
        return Internship::with(['offer','agreement'])->whereHas('agreement.university', function (Builder $query) use ($slug) {
            $query->where('slug', $slug);
        })->get();
    }
}
