<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
                Rule::requiredIf(
                    function () {
                        return empty($this->company['name']);
                    }
                ),
                'exists:App\Models\Company,id',
            ],
            'company.name' => [
                Rule::requiredIf(
                    function () {
                        return empty($this->company['id']);
                    }
                ),
                'max:64',
            ],
            'company.street' => [
                Rule::requiredIf(
                    function () {
                        return empty($this->company['id']);
                    }
                ),
                'max:64',
            ],
            'company.streetNumber' => [
                Rule::requiredIf(
                    function () {
                        return empty($this->company['id']);
                    }
                ),
                'max:8',
            ],
            'company.cityPostCode' => [
                Rule::requiredIf(
                    function () {
                        return empty($this->company['id']);
                    }
                ),
                'max:6',
            ],
            'company.cityName' => [
                Rule::requiredIf(
                    function () {
                        return empty($this->company['id']);
                    }
                ),
                'max:64',
            ],
            'company.email' => [
                Rule::requiredIf(
                    function () {
                        return empty($this->company['id']);
                    }
                ),
                'email',
                'max:64',
            ],
            'company.phone' => [
                'max:16',
            ],
            'company.website' => [
                'max:64',
            ],
            'company.categoryId' => [
                Rule::requiredIf(
                    function () {
                        return empty($this->company['id']);
                    }
                ),
                'exists:App\Models\CompanyCategory,id',
            ],
            'offer.name' => ['required', 'max:80'],
            'offer.program' => ['required'],
            'offer.categoryId' => [
                'required',
                'exists:App\Models\OfferCategory,id',
            ],
            'offer.attachments' => ['mime:pdf'],
            'agreement.dateFrom' => ['required', 'date'],
            'agreement.dateTo' => ['required', 'date'],
        ];
    }

    public function messages()
    {
        return [
            'company.id.requiredIf' => 'Pole jest wymagan.',
            'company.id.exists' => 'Dana firma nie podana firma nie istniej.',
            'company.name.requiredId' => 'Pole jest wymagan.',
            'company.street.requiredId' => 'Pole jest wymagan.',
            'company.streetNumber.requiredId' => 'Pole jest wymagan.',
            'company.cityPostCode.requiredId' => 'Pole jest wymagan.',
            'company.cityName.requiredId' => 'Pole jest wymagan.',
            'company.email.requiredId' => 'Pole jest wymagan.',
            'offer.name.required' => 'Pole jest wymagan.',
            'offer.program.required' => 'Pole jest wymagan.',
            'company.name.max' => 'Pole nie może przekraczać :max znaków.',
            'company.street.max' => 'Pole nie może przekraczać :max znaków.',
            'company.streetNumber.max' => 'Pole nie może przekraczać :max znaków.',
            'company.cityPostCode.max' => 'Pole nie może przekraczać :max znaków.',
            'company.cityName.max' => 'Pole nie może przekraczać :max znaków.',
            'company.email.max' => 'Pole nie może przekraczać :max znaków.',
            'company.email.email' => 'Pole musi zawierać prawidłowy email.',
            'company.phone.max' => 'Pole nie może przekraczać :max znaków.',
            'company.website.max' => 'Pole nie może przekraczać :max znaków.',
            'company.categoryId.exists' => 'Dana kategoria firmy nie istniej.',
            'offer.name.max' => 'Pole nie może przekraczać :max znaków.',
            'offer.categoryId.exists' => 'Dana kategoria nie istniej.',
            'offer.attachments.mime' => 'Plik musi być formatu PDF.',
            'agreement.dateFrom.date' => 'Pole musi zawierać prawidłową datę',
            'agreement.dateTo.date' => 'Pole musi zawierać prawidłową datę',
        ];
    }
}
