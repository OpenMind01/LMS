<?php

namespace Pi\Http\Requests\Users;

use Pi\Http\Requests\Request;
use Pi\Auth\User;
use Pi\Auth\Permission;

class UserCreateRequest extends Request
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
        $rules = User::rules($this->users);

        if (!empty($this->get('password')))
        {
            $rules['password'] = 'required|min:6';
            $rules['repeat_password'] = 'required|same:password';
        }

        return $rules;
    }
}
