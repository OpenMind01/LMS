<?php

namespace Pi\Http\Requests\Clients\Activation;

use Pi\Http\Requests\Request;

class UsergroupsRequest extends Request
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