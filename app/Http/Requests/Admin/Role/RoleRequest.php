<?php

namespace App\Http\Requests\Admin\Role;

use App\Services\Requests\ApiRequest;

class RoleRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->canDo(['SUPER_ADMINISTRATOR', 'ROLE_CHANGE']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|string|min:2|max:255',
            'alias' => 'required|string|min:2|max:255',
        ];
    }
}
