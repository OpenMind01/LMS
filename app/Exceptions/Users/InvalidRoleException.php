<?php

namespace Pi\Exceptions\Users;

use Pi\Exceptions\IErrorMessageException;

class InvalidRoleException extends \Exception implements IErrorMessageException
{
    public function __construct()
    {
        parent::__construct('Invalid role');
    }
}