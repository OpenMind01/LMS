<?php

namespace Pi\Exceptions\Clients\Users\Import;

use Pi\Exceptions\IErrorMessageException;

class EmailColumnDoesntExistException extends \Exception implements IErrorMessageException
{
    public function __construct()
    {
        parent::__construct('One of columns must be Email');
    }
}