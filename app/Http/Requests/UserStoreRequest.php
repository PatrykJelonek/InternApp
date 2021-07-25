<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
            'firstName' => 'required|max:64',
            'lastName' => 'required|max:64',
            'phone' => 'required|max:16',
            'email' => 'required|unique:users|max:64',
            'password' => 'required|max:255',
        ];
    }
}
