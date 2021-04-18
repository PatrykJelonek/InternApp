<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateStudentOwnInternshipRequest extends FormRequest
{
    /**
     * @var mixed
     */
    private $company;

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
            'offer.name' => 'required',
            'offer.program' => 'required',
            'offer.schedule' => 'required',
            'offer.categoryId' => 'required',
            'offer.attachments' => 'file',
            'agreement.dateFrom' => 'date',
            'agreement.dateTo' => 'date',
        ];
    }
}
