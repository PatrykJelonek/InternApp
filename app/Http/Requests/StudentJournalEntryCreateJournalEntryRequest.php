<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentJournalEntryCreateJournalEntryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    public function all($keys = null): ?array
    {
        return array_merge(parent::all(), $this->route()->parameters());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'content' => 'required',
            'students_ids' => 'nullable|array',
            'internship' => 'required|exists:App\Models\Internship,id',
            'student' => 'required|exists:App\Models\Student,student_index',
        ];
    }

    public function messages(): array
    {
        return [
            'content.required' => 'Treść wpisu jest wymagana!',
            'students_ids.array' => 'Wartość musi być tablicą!',
            'internship.required' => 'Identyfikator praktyki jest wymagany!',
            'internship.exists' => 'Nie istnieje praktyka o takim identyfikatorze!',
            'student.required' => 'Identyfikator studenta jest wymagany!',
            'student.exists' => 'Nie istnieje student o takim identyfikatorze!',
        ];
    }
}
