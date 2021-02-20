<?php

namespace App\Repositories;

use App\Models\Agreement;
use App\Repositories\Interfaces\InternshipRepositoryInterface;

class InternshipRepository implements InternshipRepositoryInterface {

    /**
     * @param $agreementId
     * @return mixed
     */
    public function one($agreementId)
    {
        return Agreement::find($agreementId)->internships;
    }

    public function all()
    {
        // TODO: Implement all() method.
    }
}
