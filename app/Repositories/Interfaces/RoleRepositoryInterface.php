<?php
/**
 * Created by PhpStorm.
 * User: Patryk Jelonek (patryk)
 * Date: 16/07/2021
 * Time: 21:27
 */

namespace App\Repositories\Interfaces;

use App\Models\Role;

interface RoleRepositoryInterface
{
    /**
     * @param array|null $groups
     *
     * @return mixed
     */
    public function getAvailableRolesByGroups(?array $groups = []);
}
