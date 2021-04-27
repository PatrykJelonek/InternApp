<?php
/**
 * Created by PhpStorm.
 * User: Patryk Jelonek (patryk)
 * Date: 21/04/2021
 * Time: 22:56
 */

namespace App\Repositories;

use App\Models\OfferStatus;
use App\Repositories\Interfaces\OfferStatusRepositoryInterface;
use Carbon\Carbon;

class OfferStatusRepository implements OfferStatusRepositoryInterface
{

    public function getOfferStatusById(int $id)
    {
        return OfferStatus::find($id);
    }

    public function getOfferStatusByName(string $name)
    {
        return OfferStatus::where(['name' => $name])->first();
    }

    public function createOfferStatus(array $data)
    {
        $offerStatus = new OfferStatus();
        $offerStatus->name = $data['name'];
        $offerStatus->description = $data['description'];
        $offerStatus->display_name = $data['displayName'];
        $offerStatus->hex_color = $data['hexColor'];
        $offerStatus->created_at = Carbon::today();
        $offerStatus->updated_at = Carbon::today();

        if ($offerStatus->save()) {
            return $offerStatus;
        }

        return null;
    }

    public function updateOfferStatusById(int $id)
    {
        // TODO: Implement updateOfferStatusById() method.
    }

    public function deleteOfferStatusById(int $id)
    {
        // TODO: Implement deleteOfferStatusById() method.
    }

    public function getAllOfferStatuses()
    {
        return OfferStatus::all();
    }
}
