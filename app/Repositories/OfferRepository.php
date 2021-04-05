<?php
/**
 * Created by PhpStorm.
 * User: Patryk Jelonek (patryk)
 * Date: 05/04/2021
 * Time: 18:37
 */

namespace App\Repositories;

use App\Models\Offer;
use App\Repositories\Interfaces\OfferRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

class OfferRepository implements OfferRepositoryInterface
{
    private $with = ['status', 'category'];

    public function one(string $slug)
    {
        return Offer::with($this->with)->where('slug', $slug)->get();
    }

    public function all(array $categories)
    {
        return Offer::with(['status'])->whereHas(
            'status',
            function (Builder $query) use ($categories) {
                $query->where('name', 'IN', $categories);
            }
        )->get();
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
