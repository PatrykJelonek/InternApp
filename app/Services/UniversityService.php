<?php
/**
 * Created by PhpStorm.
 * User: Patryk Jelonek (patryk)
 * Date: 16/07/2021
 * Time: 22:51
 */

namespace App\Services;

use App\Models\University;
use App\Models\UserUniversity;
use App\Repositories\StudentRepository;
use App\Repositories\UniversityRepository;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UniversityService
{
    /**
     * @var UniversityRepository
     */
    private $universityRepository;

    /**
     * @var StudentRepository
     */
    private $studentRepository;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @param UniversityRepository $universityRepository
     * @param StudentRepository    $studentRepository
     * @param UserRepository       $userRepository
     */
    public function __construct(
        UniversityRepository $universityRepository,
        StudentRepository $studentRepository,
        UserRepository $userRepository
    ) {
        $this->universityRepository = $universityRepository;
        $this->studentRepository = $studentRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @param int   $userUniversityId
     * @param array $rolesIds
     *
     * @throws \Exception
     */
    public function changeUniversityWorkerRoles(int $userUniversityId, array $rolesIds)
    {
        try {
            $userUniversity = UserUniversity::find($userUniversityId);
            $userUniversity->roles()->sync($rolesIds);
        } catch (\Exception $e) {
            throw new \Exception('Nie udało się dodać roli!');
        }
    }

    public function verifyUniversityWorker(string $slug, int $userId)
    {
        $university = $this->universityRepository->getUniversityBySlug($slug);

        if (!is_null($university)) {
            $userUniversity = $this->universityRepository->getUserUniversity($userId, $university->id);

            if (!is_null($userUniversity)) {
                $userUniversity->verified = true;

                if ($userUniversity->save()) {
                    return $userUniversity->user;
                }
            }
        }

        return null;
    }

    public function rejectUniversityWorker(string $slug, int $userId)
    {
        $university = $this->universityRepository->getUniversityBySlug($slug);

        DB::beginTransaction();
        if (!is_null($university)) {
            $universityWorker = $this->userRepository->getUserById($userId);
            $userUniversityRoles = $this->universityRepository->getUsersUniversitiesRoles($userId, $university->id);

            if (!is_null($universityWorker) && !is_null($userUniversityRoles)) {
                $isAllUserUniversityRolesDeleted = true;

                foreach ($userUniversityRoles as $userUniversityRole) {
                    $isAllUserUniversityRolesDeleted = $userUniversityRole->delete();
                }

                if ($isAllUserUniversityRolesDeleted) {
                    $university->users()->detach($userId);
                }

                DB::commit();
                return $universityWorker;
            }
        }

        DB::rollBack();
        return null;
    }

    /**
     * @param string      $name
     * @param int         $universityTypeId
     * @param int         $cityId
     * @param string      $street
     * @param string      $streetNumber
     * @param string      $email
     * @param string      $phone
     * @param string|null $website
     * @param string|null $logoUrl
     * @param int|null    $userId
     *
     * @return University|null
     */
    public function createUniversity(
        string $name,
        int $universityTypeId,
        int $cityId,
        string $street,
        string $streetNumber,
        string $email,
        string $phone,
        ?string $website = null,
        ?string $logoUrl = null,
        ?int $userId = null
    ): ?University {
        $generatedAccessCode = UtilsService::generateAccessCode();

        $university = new University();
        $university->name = $name;
        $university->university_type_id = $universityTypeId;
        $university->city_id = $cityId;
        $university->street = $street;
        $university->street_number = $streetNumber;
        $university->email = $email;
        $university->phone = $phone;
        $university->website = $website;
        $university->access_code = $generatedAccessCode;
        $university->slug = Str::slug($name);
        $university->logo_url = $logoUrl;
        $university->user_id = !is_null($userId) ? $userId : Auth::id();
        $university->freshTimestamp();

        if ($university->save()) {
            return $university;
        }

        return null;
    }

    public function addUserToUniversityWithRole(
        int $userId,
        int $universityId,
        int $roleId,
        ?bool $verified = false,
        ?bool $active = false
    ) {
        $userUniversity = new UserUniversity();
        $userUniversity->user_id = !empty($userId) ? $userId : Auth::id();
        $userUniversity->university_id = $universityId;
        $userUniversity->verified = $verified;
        $userUniversity->active = $active;

        if ($userUniversity->save()) {
            $userUniversity->roles()->attach(
                [$roleId],
                [
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]
            );

            Log::channel(config('global.defaultLogChannel'))->info(
                'Dodano nową rolę do użytkownika uczelni!',
                [
                    'user_id' => Auth::id(),
                    'data' => [
                        'userId' => $userId,
                        'universityId' => $universityId,
                        'roleId' => $roleId,
                    ],
                ]
            );

            return $userUniversity;
        }

        Log::channel(config('global.defaultLogChannel'))->error(
            'Wystąpił problem z dodaniem roli do użytkownika uczelni!',
            [
                'user_id' => Auth::id(),
                'data' => [
                    'userId' => $userId,
                    'universityId' => $universityId,
                    'roleId' => $roleId,
                ],
            ]
        );

        return null;
    }

    public function verifyUniversity(string $slug)
    {
        $university = $this->universityRepository->getUniversityBySlug($slug);
        $university->verified = 1;

        if ($university->update()) {
            return $university;
        }

        return null;
    }

    /**
     * @param string $slug
     *
     * @return null|University
     */
    public function rejectUniversity(string $slug): ?University
    {
        $university = $this->universityRepository->getUniversityBySlug($slug);
        $universityAuthor = $university->user;

        DB::beginTransaction();
        if (!is_null($university) && !is_null($universityAuthor)) {
            $userUniversityRole = $this->universityRepository->getUsersUniversitiesRoles(
                $universityAuthor->id,
                $university->id
            );

            if (!is_null($userUniversityRole)) {
                $userUniversityRole->delete();
                $university->users()->detach($universityAuthor->id);

                if ($university->delete()) {
                    DB::commit();
                    return $university;
                }
            }
        }

        DB::rollBack();
        return null;
    }

    public function verifyStudentInUniversity(string $slug, int $userId)
    {
        $university = $this->universityRepository->getUniversityBySlug($slug);
        $student = $this->studentRepository->getStudentByUserId($userId);

        if (!is_null($university) && !is_null($student)) {
            $userUniversity = $this->universityRepository->getUserUniversity($userId, $university->id);

            if (!is_null($userUniversity)) {
                $userUniversity->verified = true;

                if ($userUniversity->update()) {
                    return $student;
                }
            }
        }

        return null;
    }

    public function rejectStudentInUniversity(string $slug, int $userId)
    {
        $university = $this->universityRepository->getUniversityBySlug($slug);
        $student = $this->studentRepository->getStudentByUserId($userId);

        DB::beginTransaction();
        if (!is_null($university) && !is_null($student)) {
            $userUniversity = $this->universityRepository->getUserUniversity($userId, $university->id);

            if (!is_null($userUniversity)) {
                $userUniversityRole = $this->universityRepository->getUsersUniversitiesRoles($userId, $university->id);

                if (!is_null($userUniversityRole) &&
                    $userUniversityRole->delete() &&
                    $userUniversity->delete() &&
                    $student->delete()
                ) {
                    DB::commit();
                    return $student;
                }
            }
        }

        DB::rollBack();
        return null;
    }
}
