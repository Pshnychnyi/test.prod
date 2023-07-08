<?php

namespace App\Http\Requests\Pub\Auth\Api;

use App\Services\Requests\ApiRequest;

class RegistrationRequest extends ApiRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'login' => 'required|min:3|max:255',
            'name' => 'required|min:3|max:255',
            'phone' => 'nullable|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ];
    }
}
