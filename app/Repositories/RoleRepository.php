<?php
/**
 * Created by PhpStorm.
 * User: Patryk Jelonek (patryk)
 * Date: 16/07/2021
 * Time: 21:43
 */

namespace App\Repositories;

use App\Models\Role;
use App\Repositories\Interfaces\RoleRepositoryInterface;

class RoleRepository implements RoleRepositoryInterface
{
    /**
     * @param array|null $groups
     *
     * @return array|mixed
     * @throws \Exception
     */
    public function getAvailableRolesByGroups(?array $groups = [])
    {
        try {
            $roles = Role::whereIn('group', $groups)->get();
        } catch (\Exception $exception) {
            throw new \Exception('Nie udało się pobrać roli!');
        }

        return $roles ?? [];
    }
}
