<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInternshipRequest extends FormRequest
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
            'offerId' => 'required|numeric|exists:offers,id',
            'agreementId' => 'required|numeric|exists:agreements,id',
            'companySupervisorId' => 'required|numeric|exists:offers,company_supervisor_id',
            'universitySupervisorId' => 'required|numeric|exists:agreements,university_supervisor_id'
        ];
    }
}
