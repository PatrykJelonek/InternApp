<?php
/**
 * Created by PhpStorm.
 * User: Patryk Jelonek (patryk)
 * Date: 16/07/2021
 * Time: 22:51
 */

namespace App\Services;

use App\Models\UserUniversity;

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
}
