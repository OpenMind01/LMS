<?php

namespace Pi\Exceptions\Clients;

use Pi\Exceptions\IErrorMessageException;

class EmptyUsergroupsException extends \Exception implements IErrorMessageException
{
    public function __construct()
    {
        parent::__construct('At least one user group should be chosen');
    }
}