<?php

namespace Pi\Http\Requests\Users;

use Pi\Http\Requests\Request;
use Pi\Auth\User;
use Pi\Auth\Permission;

class UserUpdateRequest extends Request
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
        //@todo this needs to be filled in so that an update request has specific rules
        $rules = [];
        return $rules;
    }
}
