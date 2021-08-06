<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UniversityAddStudentToUniversityRequest extends FormRequest
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
            'userId' => 'required|exists:App\Models\User,id',
            'index' => 'required|numeric',
            'semester' => 'required|numeric|min:1|max:10',
            'specializationId' => 'required|exists:App\Models\Specialization,id',
        ];
    }
}
