<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ChatGetUserChatsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::id() === $this->all()['userId'] || Auth::user()->hasRole(['admin']);
    }

    public function all($keys = null): array
    {
        $data = parent::all();
        $data['userId'] = parent::all()['userId'] ?? Auth::id();

        return $data;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'userId' => 'required|exists:App\Models\User,id',
        ];
    }

    public function messages(): array
    {
        return [
            'userId.required' => 'ID użytkownika jest wymagane.',
            'userId.exists' => 'Podany użytkownik nie istnieje',
        ];
    }
}
