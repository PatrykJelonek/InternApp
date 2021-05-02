<?php
/**
 * Created by PhpStorm.
 * User: Patryk Jelonek (patryk)
 * Date: 02/05/2021
 * Time: 02:26
 */

namespace App\Repositories;

use App\Models\AgreementStatus;
use App\Repositories\Interfaces\AgreementStatusRepositoryInterface;

class AgreementStatusRepository implements AgreementStatusRepositoryInterface
{

    public function getStatusByName(string $name)
    {
        $status = AgreementStatus::where(['name' => $name])->first();

        return $status ?? null;
    }
}
