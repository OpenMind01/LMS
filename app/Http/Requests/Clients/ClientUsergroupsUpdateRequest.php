<?php

namespace Pi\Http\Requests\Clients;

use Pi\Http\Requests\Request;

class ClientUsergroupsUpdateRequest extends Request
{
    public function rules()
    {
        return [];
    }

    /**
     * @return int[]
     */
    public function getUsergroups()
    {
        return $this->get('usergroups', []);
    }
}