<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ChatGetChatMessagesRequest extends FormRequest
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

    public function all($keys = null): array
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
            'uuid' => 'required|exists:App\Models\Chat,uuid',
        ];
    }

    public function messages()
    {
        return [
            'uuid.required' => 'UUID chatu jest wymagane.',
            'uuid.exists' => 'Podany chat nie istnieje.',
        ];
    }
}
