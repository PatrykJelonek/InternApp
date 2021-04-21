<?php
/**
 * Created by PhpStorm.
 * User: Patryk Jelonek (patryk)
 * Date: 14/03/2021
 * Time: 20:39
 */

namespace App\Repositories;

use App\Models\Company;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use Carbon\Carbon;

class CompanyRepository implements CompanyRepositoryInterface
{
    public function getOneById(int $id)
    {
        return Company::find($id);
    }

    public function getOneBySlug(string $slug)
    {
        return Company::where(['slug' => $slug])->first();
    }

    public function getAll()
    {
        return Company::all();
    }

    public function createCompany(array $data)
    {
        $company = new Company();
        $company->name = $data['company'];
        $company->street = $data['company'];
        $company->street_number = $data['company'];
        $company->email = $data['company'];
        $company->phone = $data['company'];
        $company->website = $data['company'];
        $company->description = $data['company'];
        $company->slug = $data['company'];
        $company->access_code = $data['company'];
        $company->company_category_id = $data['company'];
        $company->created_at = Carbon::today();
        $company->updated_at = Carbon::today();
    }


    public function updateCompany(array $data)
    {
        // TODO: Implement updateCompany() method.
    }

    public function deleteCompanyById(int $id)
    {
        // TODO: Implement deleteCompanyById() method.
    }

    public function deleteCompanyBySlug(string $slug)
    {
        // TODO: Implement deleteCompanyBySlug() method.
    }
}
