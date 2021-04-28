<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OfferCategory;
use App\Repositories\OfferCategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OfferCategoryController extends Controller
{
    /**
     * @var OfferCategoryRepository
     */
    private $offerCategoryRepository;

    /**
     * OfferCategoryController constructor.
     *
     * @param OfferCategoryRepository $offerCategoryRepository
     */
    public function __construct(OfferCategoryRepository $offerCategoryRepository)
    {
        $this->offerCategoryRepository = $offerCategoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $offerCategories = $this->offerCategoryRepository->getAllOfferCategories();

        if (isset($offerCategories)) {
            return response($offerCategories, Response::HTTP_OK);
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $offerCategory = new OfferCategory;


            $offerCategory->name = $request->input("name");
            $offerCategory->description = $request->input("description");
            $offerCategory->created_at = date('Y-m-d H:i:s');
            $offerCategory->updated_at = date('Y-m-d H:i:s');

            if ($offerCategory->save())
            return response($offerCategory, Response::HTTP_OK);
        else
            return response("Offer category has not been created!", Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $offerCategory = OfferCategory::find($id);

        if (isset($offerCategory))
            return response($offerCategory, Response::HTTP_OK);
        else
            return response("Offer category not found!", Response::HTTP_NOT_FOUND);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\OfferCategory  $offerCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(OfferCategory $offerCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\OfferCategory  $offerCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OfferCategory $offerCategory)
    {
        $offerCategory = OfferCategory::find($request->input("id"));

        if (isset($offerCategory)) {
            $offerCategory->name = $request->input("name");
            $offerCategory->description = $request->input("description");
            $offerCategory->updated_at = date('Y-m-d H:i:s');

            if ($offerCategory->save())
                return response($offerCategory, Response::HTTP_OK);
        }

        return response("Offer category not found!", Response::HTTP_NOT_FOUND);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $offerCategory = OfferCategory::find($id);

        if ($offerCategory->delete())
            return response("Offer category has been deleted!", Response::HTTP_OK);
        else
            return response("Offer category has not been deleted!", Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
