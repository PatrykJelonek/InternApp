<?php
/**
 * Created by PhpStorm.
 * User: Patryk Jelonek (patryk)
 * Date: 02/05/2021
 * Time: 02:25
 */

namespace App\Repositories\Interfaces;

interface AgreementStatusRepositoryInterface
{
    public function getStatusByName(string $name);
}
