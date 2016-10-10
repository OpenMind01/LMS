<?php

namespace Pi\Http\Requests\Clients\Usergroups;

use Pi\Http\Requests\Request;

class ClientUsergroupCreateRequest extends Request
{
    public function rules()
    {
        return [
            'usergroup_id' => 'required'
        ];
    }

    public function getUsergroupId()
    {
        return $this->get('usergroup_id');
    }
}