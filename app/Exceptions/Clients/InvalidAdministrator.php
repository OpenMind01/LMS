<?php

namespace Pi\Exceptions\Clients;

use Pi\Auth\User;
use Pi\Exceptions\IErrorMessageException;

class InvalidAdministrator extends \Exception implements IErrorMessageException
{
    public function __construct(User $user)
    {
        parent::__construct('This user is not an administrator: ' . $user->full_name);
    }
}