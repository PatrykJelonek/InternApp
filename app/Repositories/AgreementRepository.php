<?php
/**
 * Created by PhpStorm.
 * User: Patryk Jelonek (patryk)
 * Date: 05/04/2021
 * Time: 19:05
 */

namespace App\Repositories;

use App\Models\Agreement;
use App\Repositories\Interfaces\AgreementRepositoryInterface;

class AgreementRepository implements AgreementRepositoryInterface
{
    private $with = ['offer','university','company'];

    public function one(string $slug)
    {
        return Agreement::with($this->with)->where('slug', $slug)->first();
    }

    public function all(bool $onlyActive)
    {
        $agreements = Agreement::with($this->with);

        if($onlyActive) {
            $agreements->where('is_active', '=', true);
        }

        return $agreements->get();
    }

    public function create()
    {
        // TODO: Implement create() method.
    }

    public function edit(string $slug)
    {
        // TODO: Implement edit() method.
    }

    public function delete(string $slug)
    {
        // TODO: Implement delete() method.
    }
}
