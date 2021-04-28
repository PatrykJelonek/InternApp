<?php
/**
 * Created by PhpStorm.
 * User: Patryk Jelonek (patryk)
 * Date: 21/04/2021
 * Time: 22:55
 */

namespace App\Repositories;

use App\Models\OfferCategory;
use App\Repositories\Interfaces\OfferCategoryRepositoryInterface;
use Carbon\Carbon;

class OfferCategoryRepository implements OfferCategoryRepositoryInterface
{

    public function getOfferCategoryById(int $id)
    {
        return OfferCategory::find($id);
    }

    public function getOfferCategoryByName(string $name)
    {
        return OfferCategory::where(['name' => $name])->first();
    }

    public function createOfferCategory(array $data)
    {
        $offerCategory = new OfferCategory();
        $offerCategory->name = $data['name'];
        $offerCategory->description = $data['description'];
        $offerCategory->display_name = $data['display_name'];
        $offerCategory->created_at = Carbon::today();
        $offerCategory->updated_at = Carbon::today();

        if ($offerCategory->save()) {
            return $offerCategory;
        }

        return null;
    }

    public function updateOfferCategoryById(int $id)
    {
        // TODO: Implement updateOfferCategoryById() method.
    }

    public function deleteOfferCategoryById(int $id)
    {
        // TODO: Implement deleteOfferCategoryById() method.
    }

    public function getAllOfferCategories()
    {
        return OfferCategory::all();
    }
}
