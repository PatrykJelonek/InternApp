<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:64',
            'description' => 'required|max:255',
            'done' => 'required|boolean',
            'students_ids' => 'nullable|array'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nazwa zadania jest wymagana.',
            'name.max' => 'Długość nazwy zadanie nie może przekraczać 64 znaków.',
            'description.required' => 'Opis zadania jest wymagany.',
            'description.max' => 'Długość opisu zadania nie może przekraczać 255 znaków',
            'done.required' => 'Określ czy zadanie zostało już wykonane.',
            'done.boolean' => 'Wartość musi być typu logicznego.',
            'students_ids.array' => 'Wartość musi być tablicą.',
        ];
    }
}
