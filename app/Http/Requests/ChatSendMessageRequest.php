<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ChatSendMessageRequest extends FormRequest
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
        $all = array_merge(parent::all(), $this->route()->parameters());
        $all['userId'] = $this->request->userId ?? Auth::id();

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
            'uuid' => 'required|exists:App\Models\Chat,uuid',
            'userId' => 'required|exists:App\Models\User,id',
            'message' => 'required|string'
        ];
    }

    public function messages()
    {
        return [
          'chatUuid.required' => '',
          'chatUuid.exists' => '',
          'userId.required' => '',
          'userId.exists' => '',
          'message.required' => '',
          'message.string' => '',
        ];
    }
}
