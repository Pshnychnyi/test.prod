<?php

namespace App\Http\Requests\Admin\User;

use App\Services\Requests\ApiRequest;

class UserRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->canDo(['SUPER_ADMINISTRATOR', 'USER_CHANGE']);
    }

    protected function getValidatorInstance()
    {
        $validator = parent::getValidatorInstance();

        $validator->sometimes('password',['required'],function ($input) {

            if(!empty($input->password) || (empty($input->password) && ($this->route()->getName() != 'users.update'))) {
                return true;
            }
            return false;
        });

        return $validator;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $userId = $this->route()->parameter('user') ? $this->route()->parameter('user')->id : '';
        return [
            'name' => 'required|min:3|max:255',
            'login' => 'required|min:3|max:255',
            'phone' => 'nullable|string',
            'email' => 'required|email|unique:users,email,' . $userId,
            'role_id' => 'required|exists:roles,id'
        ];
    }
}
