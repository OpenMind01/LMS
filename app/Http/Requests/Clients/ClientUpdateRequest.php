<?php

namespace Pi\Http\Requests\Clients;

use Pi\Http\Requests\Request;

class ClientUpdateRequest extends Request
{
    public function rules()
    {
        return [
            'name' => 'required',
            'slug' => 'required',
            'administrator_id' => 'required|integer',
        ];
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->get('name');
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->get('slug');
    }

    /**
     * @return int[]
     */
    public function getIndustries()
    {
        return $this->get('industries', []);
    }

    /**
     * @return int
     */
    public function getAdministratorId()
    {
        return $this->get('administrator_id');
    }
}