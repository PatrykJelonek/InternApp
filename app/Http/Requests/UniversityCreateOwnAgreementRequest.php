<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UniversityCreateOwnAgreementRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function all($keys = null)
    {
        return array_merge(parent::all(), $this->route()->parameters());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'slug' => 'required|exists:App\Models\University,slug',
            'company.id' => 'sometimes|nullable|exists:App\Models\Company,id',
            'company.name' => 'required_without:company.id|nullable|max:255|unique:App\Models\Company,name',
            'company.street' => 'required_without:company.id|max:64',
            'company.streetNumber' => 'required_without:company.id|max:8',
            'company.city.id' => 'required_without:company.id|nullable|exists:App\Models\City,id',
            'company.city.postcode' => 'required_without_all:company.city.id|nullable|max:6',
            'company.city.name' => 'required_without_all:company.city.id|nullable|max:64',
            'company.email' => 'required_without:company.id|nullable|max:64|email',
            'company.phone' => 'required_without:company.id|max:16',
            'company.website' => 'required_without:company.id|max:64',
            'company.companyCategoryId' => 'required_without:company.id|nullable|exists:App\Models\CompanyCategory,id',
            'company.description' => 'sometimes|max:255',
            'agreement.name' => 'required|max:80',
            'agreement.dateFrom' => 'required|date',
            'agreement.dateTo' => 'required|date|gte:agreement.dateFrom',
            'agreement.program' => 'sometimes',
            'agreement.schedule' => 'sometimes',
            'agreement.content' => 'sometimes',
            'agreement.universitySupervisorId' => 'required|exists:App\Models\User,id',
            'agreement.placesNumber' => 'required|min:1',
            'agreement.active' => 'boolean',
            'agreement.signingDate' => 'sometimes|date',
            'agreement.attachments.*' => 'sometimes|nullable|mimes:pdf',
        ];
    }

    public function messages()
    {
        return parent::messages();
    }
}
