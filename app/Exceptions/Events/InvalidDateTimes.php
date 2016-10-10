<?php

namespace Pi\Exceptions\Events;

use Pi\Exceptions\IErrorMessageException;

class InvalidDateTimes extends \Exception implements IErrorMessageException
{
    public function __construct()
    {
        parent::__construct('Invalid dates');
    }
}