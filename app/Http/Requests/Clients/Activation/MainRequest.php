<?php

namespace Pi\Http\Requests\Clients\Activation;

use Pi\Http\Requests\Request;

class MainRequest extends Request
{
    public function rules()
    {
        return ['name' => 'required'];
    }

    public function getName()
    {
        return $this->get('name');
    }

    public function getDescription()
    {
        return $this->get('description');
    }
}