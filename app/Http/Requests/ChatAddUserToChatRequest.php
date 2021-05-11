<?php

namespace App\Http\Requests;

use App\Constants\RoleConstants;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ChatAddUserToChatRequest extends FormRequest
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

    public function all($keys = null): array
    {
        $data = parent::all();

        if (!isset($data['firstUserId']) || !Auth::user()->hasRole([RoleConstants::ROLE_ADMIN])) {
            $data['firstUserId'] = Auth::id();
        }

        return $data;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'firstUserId' => 'required|exists:App\Models\User,id',
            'secondUserId' => 'required|exists:App\Models\User,id',
        ];
    }

    public function messages()
    {
        return [
            'firstUserId.required' => ['ID użytkownika jest wymagane.'],
            'firstUserId.exists' => ['Podany użytkownik nie istnieje.'],
            'secondUserId.required' => ['ID użytkownika jest wymagane.'],
            'secondUserId.exists' => ['Podany użytkownik nie istnieje.'],
        ];
    }


}
