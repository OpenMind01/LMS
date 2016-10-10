<?php

namespace Pi\Exceptions\Users;

use Pi\Exceptions\IErrorMessageException;

class ExistingEmailException extends \Exception implements IErrorMessageException
{
    public function __construct($email)
    {
        parent::__construct('User with this email already exists: ' . $email);
    }
}