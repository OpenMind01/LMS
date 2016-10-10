<?php

namespace Pi\Http\Requests\Clients;

use Pi\Http\Requests\Request;

class ClientCreateRequest extends Request
{
    public function rules()
    {
        return [
            'name' => 'required',
            'ownersEmail' => 'required|email',
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
    public function getOwnersEmail()
    {
        return $this->get('ownersEmail');
    }

    /**
     * @return int
     */
    public function getAdministratorId()
    {
        return $this->get('administrator_id');
    }
}