<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use phpDocumentor\Reflection\Types\Nullable;

class CreateStudentOwnInternshipRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'company.id' => [
                'nullable',
                Rule::requiredIf(
                    function () {
                        return empty($this->company['name']);
                    }
                ),
                'exists:App\Models\Company,id',
            ],
            'company.name' => [
                'nullable',
                Rule::requiredIf(
                    function () {
                        return empty($this->company['id']);
                    }
                ),
                'max:64',
                'unique:App\Models\Company,name',
            ],
            'company.street' => [
                'nullable',
                Rule::requiredIf(
                    function () {
                        return empty($this->company['id']);
                    }
                ),
                'max:64',
            ],
            'company.streetNumber' => [
                'nullable',
                Rule::requiredIf(
                    function () {
                        return empty($this->company['id']);
                    }
                ),
                'max:8',
            ],
            'company.city.postcode' => [
                'nullable',
                Rule::requiredIf(
                    function () {
                        return empty($this->company['id']);
                    }
                ),
                'max:6',
                'unique:App\Models\City,post_code',
            ],
            'company.city.name' => [
                'nullable',
                Rule::requiredIf(
                    function () {
                        return empty($this->company['id']);
                    }
                ),
                'max:64',
            ],
//            'company.city.id' => [
//                'sometimes',
//                'required_without:company.id',
//                'exists:App\Models\City,id',
//            ],
            //'company.email' => 'required_without:company.id,null|email|max:64',
            'company.phone' => [
                'max:16',
            ],
            'company.website' => [
                'max:64',
            ],
//            'company.companyCategoryId' => [
//                'bail',
//                'required_if:company.id,null',
//                'exists:App\Models\CompanyCategory,id',
//            ],
            'agreement.name' => ['required', 'max:80','unique:App\Models\Offer,name'],
            'agreement.program' => ['required'],
            'agreement.universitySlug' => [
                'required',
                'exists:App\Models\University,slug',
            ],
            'agreement.dateFrom' => ['required', 'date'],
            'agreement.dateTo' => ['required', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            'company.id.requiredIf' => 'Pole jest wymagań.',
            'company.id.exists' => 'Dana firma nie podana firma nie istniej.',
            'company.name.requiredId' => 'Pole jest wymagań.',
            'company.name.unique' => 'Firma o takiej nazwie istnieje już w systemie',
            'company.street.requiredId' => 'Pole jest wymagań.',
            'company.streetNumber.requiredId' => 'Pole jest wymagań.',
            'company.city.postcode.requiredId' => 'Pole jest wymagań.',
            'company.city.postcode.unique' => 'Podany kod pocztowy jest już używany w systemie.',
            'company.city.name.requiredId' => 'Pole jest wymagań.',
            'company.city.id.exists' => 'Podane miasto nie istnieje w systemie.',
            'company.email.requiredId' => 'Pole jest wymagań.',
            'agreement.name.required' => 'Pole jest wymagań.',
            'agreement.name.unique' => 'Podaj inną nazwę.',
            'agreement.program.required' => 'Pole jest wymagań.',
            'company.name.max' => 'Pole nie może przekraczać :max znaków.',
            'company.street.max' => 'Pole nie może przekraczać :max znaków.',
            'company.streetNumber.max' => 'Pole nie może przekraczać :max znaków.',
            'company.cityPostCode.max' => 'Pole nie może przekraczać :max znaków.',
            'company.cityName.max' => 'Pole nie może przekraczać :max znaków.',
            'company.email.max' => 'Pole nie może przekraczać :max znaków.',
            'company.email.email' => 'Pole musi zawierać prawidłowy email.',
            'company.phone.max' => 'Pole nie może przekraczać :max znaków.',
            'company.website.max' => 'Pole nie może przekraczać :max znaków.',
            'company.companyCategoryId.exists' => 'Dana kategoria firmy nie istniej.',
            'agreement.name.max' => 'Pole nie może przekraczać :max znaków.',
            'agreement.universitySlug.exists' => 'Dana uczelnia nie istnieje.',
            'agreement.dateFrom.date' => 'Pole musi zawierać prawidłową datę',
            'agreement.dateTo.date' => 'Pole musi zawierać prawidłową datę',
        ];
    }
}
