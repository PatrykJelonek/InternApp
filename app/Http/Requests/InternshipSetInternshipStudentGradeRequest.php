<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InternshipSetInternshipStudentGradeRequest extends FormRequest
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
        $all= array_merge(parent::all(), $this->route()->parameters());
        clock()->info('aa', $all);
        return $all;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'internship' => 'required|exists:App\Models\Internship,id',
            'student' => 'required|exists:App\Models\Student,student_index',
            'grade' => [
                'required',
                Rule::in([2,2.5,3,3.5,4,4.5,5])
            ]
        ];
    }
}
