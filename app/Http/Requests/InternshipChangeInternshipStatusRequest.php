<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InternshipChangeInternshipStatusRequest extends FormRequest
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
            'id' => 'required|exists:App\Models\Internship,id',
            'statusId' => 'required|exists:App\Models\InternshipStatus,id',
        ];
    }

    public function messages()
    {
        return [
            'id.required' => 'Id praktyki jest wymagane!',
            'id.exists' => 'Podana praktyka nie istnieje!',
            'statusId.required' => 'Id nowego statusu praktyki jest wymagane!',
            'statusId.exists' => 'Podany status nie istnieje!'
        ];
    }
}
