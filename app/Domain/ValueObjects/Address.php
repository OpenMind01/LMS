<?php

namespace Pi\Domain\ValueObjects;

class Address
{
    private $country;
    private $street;
    private $street2;
    private $city;
    private $state;
    private $postal;

    /**
     * Address constructor.
     * @param $country
     * @param $street
     * @param $street2
     * @param $city
     * @param $state
     * @param $postal
     */
    public function __construct($country, $street, $street2, $city, $state, $postal)
    {
        $this->country = $country;
        $this->street = $street;
        $this->street2 = $street2;
        $this->city = $city;
        $this->state = $state;
        $this->postal = $postal;
    }

    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @return mixed
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @return mixed
     */
    public function getStreet2()
    {
        return $this->street2;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @return mixed
     */
    public function getPostal()
    {
        return $this->postal;
    }
}