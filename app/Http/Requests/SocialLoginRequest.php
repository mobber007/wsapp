<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SocialLoginRequest extends FormRequest
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
            'email' => 'required|email',
            'name' => 'required|string',
            'last_name' => 'required|string',
            'accepted' => 'required|accepted',
            'avatar' => 'required|url',
            'provider' => 'required|string',
            'provider_id' => 'required',
            'access_token' => 'required',
            'refresh_token' => 'required'
        ];
    }
}
