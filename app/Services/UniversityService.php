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
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UniversityService
{
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

    public function verifyUniversityWorker(int $userUniversityId): bool
    {
        try {
            $userUniversity = UserUniversity::find($userUniversityId);
            $userUniversity->verified = true;

            if ($userUniversity->save()) {
                return true;
            }

            throw new \Exception("Nie udało się zweryfikować pracownika!");
        } catch (\Exception $e) {
            throw new \Exception('Nie udało się zweryfikować pracownika!');
        }
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

    public function addRoleToUniversityUser(int $userId, int $universityId, int $roleId)
    {
        $userUniversity = new UserUniversity();
        $userUniversity->user_id = !empty($userId) ? $userId : Auth::id();
        $userUniversity->university_id = $universityId;

        if ($userUniversity->save()) {
            $userUniversity->roles()->attach([$roleId], ['created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);

            Log::channel('user')->info(
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

        Log::channel('user')->error(
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
}
