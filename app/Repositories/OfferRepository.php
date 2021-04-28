<?php
/**
 * Created by PhpStorm.
 * User: Patryk Jelonek (patryk)
 * Date: 05/04/2021
 * Time: 18:37
 */

namespace App\Repositories;

use App\Constants\OfferStatusConstants;
use App\Models\Offer;
use App\Repositories\Interfaces\OfferRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class OfferRepository implements OfferRepositoryInterface
{
    private $with = ['status', 'category'];

    /**
     * @var OfferCategoryRepository
     */
    private $offerCategoryRepository;

    /**
     * @var OfferStatusRepository
     */
    private $offerStatusRepository;

    /**
     * OfferRepository constructor.
     *
     * @param OfferCategoryRepository $offerCategoryRepository
     * @param OfferStatusRepository   $offerStatusRepository
     */
    public function __construct(
        OfferCategoryRepository $offerCategoryRepository,
        OfferStatusRepository $offerStatusRepository
    ) {
        $this->offerCategoryRepository = $offerCategoryRepository;
        $this->offerStatusRepository = $offerStatusRepository;
    }

    public function getOfferById(int $id)
    {
        return Offer::find($id);
    }

    public function getOfferBySlug(string $slug)
    {
        return Offer::with($this->with)->where('slug', $slug)->get();
    }

    /**
     * @param array|null $categories
     * @param array|null $statuses
     * @param int|null   $limit
     *
     * @return Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAllOffers(?array $categories, ?array $statuses, ?int $limit)
    {
        $offers = Offer::with(['status','category','company']);

        if ($statuses !== null) {
            $offers->whereHas(
                'status',
                function (Builder $query) use ($statuses) {
                    $query->where('name', $statuses);
                }
            );
        }

        if ($categories !== null) {
            $offers->whereHas(
                'category',
                function (Builder $query) use ($categories) {
                    $query->where('name',  $categories);
                }
            );
        }

        if ($limit !== null) {
            $offers->limit($limit);
        }

        $offers->orderByDesc('created_at');

        return $offers->get();
    }

    /**
     * @param array $data
     *
     * @return Offer|null
     */
    public function createOffer(array $data): ?Offer
    {
        $offer = new Offer();
        $offer->company_id = $data['companyId'] ?? 1;
        $offer->user_id = $data['userId'];
        $offer->name = $data['name'];
        $offer->places_number = $data['placesNumber'] ?? 1;
        $offer->program = $data['program'] ?? '';
        $offer->schedule = $data['schedule'] ?? '';
        $offer->offer_category_id = $data['offerCategoryId'];
        $offer->offer_status_id = $data['offerStatusId'] ?? $this->offerStatusRepository->getOfferStatusByName(
                OfferStatusConstants::STATUS_NEW
            )->toArray()['id'];
        $offer->company_supervisor_id = $data['companySupervisorId'] ?? null;
        $offer->slug = Str::slug($data['name']);
        $offer->interview = $data['interview'] ?? false;
        $offer->created_at = Carbon::today();
        $offer->updated_at = Carbon::today();

        if ($offer->save()) {
            return $offer;
        }

        return null;
    }

    public function updateOfferBySlug(string $slug)
    {
        // TODO: Implement edit() method.
    }

    public function deleteOfferBySlug(string $slug)
    {
        // TODO: Implement delete() method.
    }
}
