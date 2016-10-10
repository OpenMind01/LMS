<?php

namespace Pi\Http\Requests\Clients\Activation;

use Pi\Http\Requests\Request;

class IndustriesRequest extends Request
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