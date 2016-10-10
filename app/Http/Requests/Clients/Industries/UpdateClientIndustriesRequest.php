<?php

namespace Pi\Http\Requests\Clients\Industries;

use Pi\Http\Requests\Request;

class UpdateClientIndustriesRequest extends Request
{
    public function rules()
    {
        return [];
    }

    /**
     * @return int[]
     */
    public function getIndustries()
    {
        return $this->get('industries', []);
    }
}
