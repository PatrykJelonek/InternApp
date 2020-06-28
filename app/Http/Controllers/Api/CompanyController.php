<?php

namespace App\Http\Controllers\Api;

use App\Agreement;
use App\Company;
use App\Http\Controllers\Controller;
use App\Internship;
use App\Offer;
use App\Student;
use App\University;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        if(auth()->user()->hasRole(['user']))
        {
        $companies = Company::with(['offers'])->get();

        if (isset($companies))
            return response($companies, Response::HTTP_OK);
        else
            return response("Companies not found!", Response::HTTP_NOT_FOUND);
        }else
        {
            return response([
                        'status' => 'error',
                        'data' => null,
                        'message' => "Nie masz uprawnień!"
                    ], Response::HTTP_UNAUTHORIZED);
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
     * @return Response
     */
    public function store(Request $request)
    {
        if(auth()->user()->hasRole(['admin', 'company-worker']))
        {
        $validatedData = $request->validate([
            'name' => 'required|unique:companies|max:255',
            'companyCategoryId' => 'required',
            'cityId' => 'required',
            'street' => 'required|max:64',
            'streetNumber' => 'required|max:8',
            'email' => 'required|max:64',
            'phone' => 'required|max:16',
            'website' => 'required|max:64',
            'description' => 'required|max:255',
        ], Company::messages());

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

        if($company->save())
        {
            if($company->users()->save(auth()->user(), ['created_at' => date('Y-m-d H:i:s')]))
            {
                auth()->user()->attachRole('company-worker');
                return response([
                    'status' => 'success',
                    'data' => null,
                    'message' => 'Firma została dodana!'
                ], Response::HTTP_OK);
            }
        } else
            return response([
                'status' => 'error',
                'data' => null,
                'message' => 'Niestety nie udało się dodać twojej firmy!'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }else
        {
            return response([
                        'status' => 'error',
                        'data' => null,
                        'message' => "Nie masz uprawnień!"
                    ], Response::HTTP_UNAUTHORIZED);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return Response
     */
    public function show($id)
    {
        if(auth()->user()->hasRole(['user']))
        {
        $company = Company::with(['city','category','offers', 'offers.offerCategory'])->where(['id' => $id])->get();

        if (isset($company))
            return response([
                'status' => 'success',
                'data' => $company[0],
                'message' => null,
            ], Response::HTTP_OK);
        else
            return response([
                'status' => 'error',
                'data' => null,
                'message' => 'Nie znaleziono podanej firmy!',
            ], Response::HTTP_NOT_FOUND);
        }else
        {
            return response([
                        'status' => 'error',
                        'data' => null,
                        'message' => "Nie masz uprawnień!"
                    ], Response::HTTP_UNAUTHORIZED);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Company $company
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
     * @return Response
     */
    public function destroy($id)
    {
        if(auth()->user()->hasRole(['admin', 'company-worker']))
        {
        $company = Company::find($id);

        if ($company->delete())
            return response("Company has been deleted!", Response::HTTP_OK);
        else
            return response("Company has not been deleted!", Response::HTTP_INTERNAL_SERVER_ERROR);
        }else
        {
            return response([
                        'status' => 'error',
                        'data' => null,
                        'message' => "Nie masz uprawnień!"
                    ], Response::HTTP_UNAUTHORIZED);
        }
    }

    public function setNewAccessCode(Request $request)
    {
        //TODO: Będzie trzeba to zabezpieczyć
        if(auth()->user()->hasRole(['company-worker']))
        {
        $company = Company::find($request->input("id"));

        if(isset($company))
        {
            $company->access_code = $this->generateUniqueRandomAccessCode();

            if($company->save())
                return response([
                    'status' => 'success',
                    'data' => $company->access_code,
                    'message' => null,
                ], Response::HTTP_OK);
        }

        return response([
            'status' => 'error',
            'data' => null,
            'message' => 'New access code has been not generate!',
        ], Response::HTTP_NOT_MODIFIED);
        }else
        {
            return response([
                        'status' => 'error',
                        'data' => null,
                        'message' => "Nie masz uprawnień!"
                    ], Response::HTTP_UNAUTHORIZED);
        }
    }

    /**
     * Use access code to join to university
     *
     * @param Request $request
     * @return Response
     */
    public function useCode(Request $request)
    {
        if(auth()->user()->hasRole(['company-worker']))
        {
        $company = Company::where('access_code', $request->input('accessCode'))->first();
        $errorMessage = "Coś poszło nie tak!";

        if($company  === null)
            $errorMessage  = "Nie udało się dopasować podanego kodu do żadnej firmy!";
        else
            if((count($company ->users()->where('user_id', auth()->id())->get()) < 1))
            {
                if($company ->users()->save(auth()->user(), ['created_at' => date('Y-m-d H:i:s')]))
                {
                    auth()->user()->attachRole('company-worker');
                    return response([
                        'status' => 'success',
                        'data' => $company,
                        'message' => null
                    ], Response::HTTP_OK);
                } else
                    $errorMessage = "Nie udało się dodać Cię do tej firmy!";
            } else
                $errorMessage  = 'Należysz już do firmy do której przypisano podany kod!';

        return response([
            'status' => 'error',
            'data' => null,
            'message' => $errorMessage
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }else
        {
            return response([
                        'status' => 'error',
                        'data' => null,
                        'message' => "Nie masz uprawnień!"
                    ], Response::HTTP_UNAUTHORIZED);
        }
    }

    /**
     * Get company offers
     *
     * @param $id
     * @return Response
     */
    public function getCompanyOffers($id) {
        if(auth()->user()->hasRole(['user']))
        {
        $offers = Offer::with(['company','offerCategory','offerStatus','company.city', 'supervisor'])->where(['company_id' => $id])->get();

        if (isset($offers))
            return response([
                'status' => 'success',
                'data' => $offers,
                'message' => null
            ], Response::HTTP_OK);
        else
            return response([
                'status' => 'error',
                'data' => null,
                'message' => "Nie znaleziono oferty!"
            ], Response::HTTP_NOT_FOUND);
        }else
        {
            return response([
                        'status' => 'error',
                        'data' => null,
                        'message' => "Nie masz uprawnień!"
                    ], Response::HTTP_UNAUTHORIZED);
        }
    }

    /**
     * Get company agreements
     *
     * @param $id
     * @return Response
     */
    public function getCompanyAgreements($id) {
        if(auth()->user()->hasRole(['user']))
        {
        $agreements = Agreement::with(['offer', 'university'])->where(['company_id' => $id])->get();

        if (isset($agreements))
            return response([
                'status' => 'success',
                'data' => $agreements,
                'message' => null
            ], Response::HTTP_OK);
        else
            return response([
                'status' => 'error',
                'data' => null,
                'message' => "Nie znaleziono oferty!"
            ], Response::HTTP_NOT_FOUND);
        }else
        {
            return response([
                        'status' => 'error',
                        'data' => null,
                        'message' => "Nie masz uprawnień!"
                    ], Response::HTTP_UNAUTHORIZED);
        }
    }

    /**
     * Generate unique random access code.
     *
     * @return string
     */
    private function generateUniqueRandomAccessCode()
    {
        if(auth()->user()->hasRole(['user']))
        {
        do {
            $randomAccessCode = Str::upper( Str::random(8));
        } while(count(Company::where('access_code', $randomAccessCode)->get()) > 0);

        return $randomAccessCode;
        }else
        {
            return response([
                        'status' => 'error',
                        'data' => null,
                        'message' => "Nie masz uprawnień!"
                    ], Response::HTTP_UNAUTHORIZED);
        }
    }
    /**
     * Get users from company
     * @param $id
     * @return Response
     */

    public function getUsers($id)
    {
        if(auth()->user()->hasRole(['admin', 'company-worker', 'university-worker']))
        {
        $company = Company::find($id);

         if (isset($company))
             return response([
                 'status' => 'success',
                 'data' => $company->users,
                 'message' => null
             ], Response::HTTP_OK);
        else
            return response([
                'status' => 'error',
                'data' => null,
                'message' => "Company users not found!"
            ], Response::HTTP_NOT_FOUND);
        }else
        {
            return response([
                        'status' => 'error',
                        'data' => null,
                        'message' => "Nie masz uprawnień!"
                    ], Response::HTTP_UNAUTHORIZED);
        }
    }

    /**
     * Get company interns
     *
     * @param $id
     * @return Response
     */
    public function getInterns($id)
    {
        if(auth()->user()->hasRole(['admin', 'company-worker', 'university-worker']))
        {
        $company = Company::with('offers')->find($id);
        $internships = Internship::whereIn('offer_id', Arr::pluck($company->offers, 'id'))->get();
        $students = Student::with(['user', 'internships.offer'])->whereIn('id', Arr::pluck($internships, 'student_id'))->get();

        return Response([
            'status' => 'success',
            'data' => $students,
            'message' => null,
        ], Response::HTTP_OK);
        }else
        {
            return response([
                        'status' => 'error',
                        'data' => null,
                        'message' => "Nie masz uprawnień!"
                    ], Response::HTTP_UNAUTHORIZED);
        }
    }
}
