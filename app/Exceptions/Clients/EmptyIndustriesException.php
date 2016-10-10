<?php

namespace Pi\Exceptions\Clients;

use Pi\Exceptions\IErrorMessageException;

class EmptyIndustriesException extends \Exception implements IErrorMessageException
{
    public function __construct()
    {
        parent::__construct('At least one industry should be chosen');
    }
}