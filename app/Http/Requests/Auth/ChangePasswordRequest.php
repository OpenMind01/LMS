<?php

namespace Pi\Http\Requests\Auth;

use Pi\Http\Requests\Request;

class ChangePasswordRequest extends Request
{
    public function rules()
    {
        return [
            'current_password' => 'required',
            'new_password' => 'required|min:6',
            'repeat_password' => 'required|same:new_password',
        ];
    }

    public function getCurrentPassword()
    {
        return $this->get('current_password');
    }

    public function getNewPassword()
    {
        return $this->get('new_password');
    }
}
