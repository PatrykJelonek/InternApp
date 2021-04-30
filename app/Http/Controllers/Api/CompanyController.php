<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CompanyOffersRequest;
use App\Http\Requests\CompanyShowRequest;
use App\Http\Requests\GetCompanyWorkersRequest;
use App\Models\Agreement;
use App\Models\Company;
use App\Http\Controllers\Controller;
use App\Models\Internship;
use App\Models\Offer;
use App\Models\Student;
use App\Models\University;
use App\Repositories\CompanyRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class CompanyController extends Controller
{
    /**
     * @var CompanyRepository
     */
    private $companyRepository;

    /**
     * CompanyController constructor.
     *
     * @param CompanyRepository $companyRepository
     */
    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $companies = Company::select(
            ['id', 'name', 'city_id', 'street', 'street_number', 'email', 'phone', 'website', 'company_category_id']
        )->get();

        if (isset($companies)) {
            return response($companies, Response::HTTP_OK);
        } else {
            return response("Companies not found!", Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate(
            [
                'name' => 'required|unique:companies|max:255',
                'companyCategoryId' => 'required',
                'cityId' => 'required',
                'street' => 'required|max:64',
                'streetNumber' => 'required|max:8',
                'email' => 'required|max:64',
                'phone' => 'required|max:16',
                'website' => 'required|max:64',
                'description' => 'required|max:255',
            ],
            Company::messages()
        );

        $company = new Company;

        $company->name = $request->input('name');
        $company->company_category_id = $request->input('companyCategoryId');
        $company->city_id = $request->input('cityId');
        $company->street = $request->input('street');
        $company->street_number = $request->input('streetNumber');
        $company->email = $request->input('email');
        $company->phone = $request->input('phone');
        $company->website = $request->input('website');
        $company->description = $request->input('description');
        $company->created_at = date('Y-m-d H:i:s');
        $company->updated_at = date('Y-m-d H:i:s');

        if ($company->save()) {
            if ($company->users()->save(auth()->user(), ['created_at' => date('Y-m-d H:i:s')])) {
                auth()->user()->attachRole('company-worker');
                return response(
                    [
                        'status' => 'success',
                        'data' => null,
                        'message' => 'Firma została dodana!',
                    ],
                    Response::HTTP_OK
                );
            }
        } else {
            return response(
                [
                    'status' => 'error',
                    'data' => null,
                    'message' => 'Niestety nie udało się dodać twojej firmy!',
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param CompanyShowRequest $request
     * @param                    $slug
     *
     * @return Response
     */
    public function show(CompanyShowRequest $request, $slug)
    {
        $company = $this->companyRepository->getOneBySlug($slug);

        if ($company !== null) {
            return response($company, Response::HTTP_OK);
        }

        return response(null, Response::HTTP_NOT_FOUND);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Company $company
     *
     * @return Response
     */
    public function edit(Company $company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function update(Request $request)
    {
        //TODO: Create method to update company
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $company = Company::find($id);

        if ($company->delete()) {
            return response("Company has been deleted!", Response::HTTP_OK);
        } else {
            return response("Company has not been deleted!", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function setNewAccessCode(Request $request)
    {
        //TODO: Będzie trzeba to zabezpieczyć
        $company = Company::find($request->input("id"));

        if (isset($company)) {
            $company->access_code = $this->generateUniqueRandomAccessCode();

            if ($company->save()) {
                return response(
                    [
                        'status' => 'success',
                        'data' => $company->access_code,
                        'message' => null,
                    ],
                    Response::HTTP_OK
                );
            }
        }

        return response(
            [
                'status' => 'error',
                'data' => null,
                'message' => 'New access code has been not generate!',
            ],
            Response::HTTP_NOT_MODIFIED
        );
    }

    /**
     * Use access code to join to university
     *
     * @param Request $request
     *
     * @return Response
     */
    public function useCode(Request $request)
    {
        $company = Company::where('access_code', $request->input('accessCode'))->first();
        $errorMessage = "Coś poszło nie tak!";

        if ($company === null) {
            $errorMessage = "Nie udało się dopasować podanego kodu do żadnej firmy!";
        } else {
            if ((count($company->users()->where('user_id', auth()->id())->get()) < 1)) {
                if ($company->users()->save(auth()->user(), ['created_at' => date('Y-m-d H:i:s')])) {
                    auth()->user()->attachRole('company-worker');
                    return response(
                        [
                            'status' => 'success',
                            'data' => $company,
                            'message' => null,
                        ],
                        Response::HTTP_OK
                    );
                } else {
                    $errorMessage = "Nie udało się dodać Cię do tej firmy!";
                }
            } else {
                $errorMessage = 'Należysz już do firmy do której przypisano podany kod!';
            }
        }

        return response(
            [
                'status' => 'error',
                'data' => null,
                'message' => $errorMessage,
            ],
            Response::HTTP_INTERNAL_SERVER_ERROR
        );
    }

    /**
     * Get company offers
     *
     * @param $slug
     *
     * @return Response
     */
    public function getCompanyOffers(CompanyOffersRequest $request, $slug)
    {
       $offers = $this->companyRepository->getCompanyOffers($slug);

       if (isset($offers) && count($offers) > 0) {
           return response($offers, Response::HTTP_OK);
       }

       return response(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Get company agreements
     *
     * @param $id
     *
     * @return Response
     */
    public function getCompanyAgreements($id)
    {
        $agreements = Agreement::with(['offer', 'university'])->where(['company_id' => $id])->get();

        if (isset($agreements)) {
            return response(
                [
                    'status' => 'success',
                    'data' => $agreements,
                    'message' => null,
                ],
                Response::HTTP_OK
            );
        } else {
            return response(
                [
                    'status' => 'error',
                    'data' => null,
                    'message' => "Nie znaleziono oferty!",
                ],
                Response::HTTP_NOT_FOUND
            );
        }
    }

    /**
     * Generate unique random access code.
     *
     * @return string
     */
    private function generateUniqueRandomAccessCode()
    {
        do {
            $randomAccessCode = Str::upper(Str::random(8));
        } while (count(Company::where('access_code', $randomAccessCode)->get()) > 0);

        return $randomAccessCode;
    }

    /**
     * Get users from company
     *
     * @param $id
     *
     * @return Response
     */

    public function getUsers($id)
    {
        $company = Company::find($id);

        if (isset($company)) {
            return response(
                [
                    'status' => 'success',
                    'data' => $company->users,
                    'message' => null,
                ],
                Response::HTTP_OK
            );
        } else {
            return response(
                [
                    'status' => 'error',
                    'data' => null,
                    'message' => "Company users not found!",
                ],
                Response::HTTP_NOT_FOUND
            );
        }
    }

    /**
     * Get company interns
     *
     * @param $id
     *
     * @return Response
     */
    public function getInterns($id)
    {
        $company = Company::with('offers')->find($id);
        $internships = Internship::whereIn('offer_id', Arr::pluck($company->offers, 'id'))->get();
        $students = Student::with(['user', 'internships.offer'])->whereIn(
            'id',
            Arr::pluck($internships, 'student_id')
        )->get();

        return Response(
            [
                'status' => 'success',
                'data' => $students,
                'message' => null,
            ],
            Response::HTTP_OK
        );
    }

    public function getCompanyWorkers(GetCompanyWorkersRequest $request, $slug) {
        $companyWorkers = $this->companyRepository->getCompanyWorkers($slug);

        if(!empty($companyWorkers)) {
            return response($companyWorkers, Response::HTTP_OK);
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
