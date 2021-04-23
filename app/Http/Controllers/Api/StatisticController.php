<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\AdminStatisticsRequest;
use App\Repositories\StatisticRepository;
use Illuminate\Http\Response;

class StatisticController extends Controller
{
    /**
     * @var StatisticRepository
     */
    private $statisticRepository;

    /**
     * StatisticController constructor.
     *
     * @param StatisticRepository $statisticRepository
     */
    public function __construct(StatisticRepository $statisticRepository)
    {
        $this->statisticRepository = $statisticRepository;
    }

    public function getNumberOfOffers(AdminStatisticsRequest $request)
    {
        $statistics = $this->statisticRepository->getNumberOfAllOffers();

        if($statistics) {
            return response($statistics, Response::HTTP_OK);
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function getNumberOfUsers(AdminStatisticsRequest $request)
    {
        $statistics = $this->statisticRepository->getNumberOfAllUsers();

        if($statistics) {
            return response($statistics, Response::HTTP_OK);
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function getNumberOfAgreements(AdminStatisticsRequest $request)
    {
        $statistics = $this->statisticRepository->getNumberOfAllAgreements();

        if($statistics) {
            return response($statistics, Response::HTTP_OK);
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function getNumberOfUniversities(AdminStatisticsRequest $request)
    {
        $statistics = $this->statisticRepository->getNumberOfAllUniversities();

        if($statistics) {
            return response($statistics, Response::HTTP_OK);
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function getNumberOfCompanies(AdminStatisticsRequest $request)
    {
        $statistics = $this->statisticRepository->getNumberOfAllCompanies();

        if($statistics) {
            return response($statistics, Response::HTTP_OK);
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function getNumberOfAttachments(AdminStatisticsRequest $request)
    {
        $statistics = $this->statisticRepository->getNumberOfAllAttachments();

        if($statistics) {
            return response($statistics, Response::HTTP_OK);
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function getNumberOfOffersAttachments(AdminStatisticsRequest $request)
    {
        $statistics = $this->statisticRepository->getNumberOfAllOffersAttachments();

        if($statistics) {
            return response($statistics, Response::HTTP_OK);
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
