<?php

namespace Pi\Http\Requests\Users;

use Pi\Domain\ValueObjects\Address;
use Pi\Http\Requests\Request;

class UserActivationRequest extends Request
{
    public function rules()
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            // @TODO add validation for phones and addresses
        ];
    }

    public function getFirstName()
    {
        return $this->get('first_name');
    }

    public function getLastName()
    {
        return $this->get('last_name');
    }

    public function getMobilePhone()
    {
        return $this->get('phone_mobile');
    }

    public function getWorkPhone()
    {
        return $this->get('phone_work');
    }

    public function getHomePhone()
    {
        return $this->get('phone_home');
    }

    public function getAddress()
    {
        return new Address(
            'US',
            $this->get('address_street'),
            $this->get('address_street2'),
            $this->get('address_city'),
            $this->get('address_state'),
            $this->get('address_postal')
        );
    }
}