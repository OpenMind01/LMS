<?php

namespace Pi\Exceptions\Clients\Users\Import;

use Pi\Exceptions\IErrorMessageException;

class NamesConflictException extends \Exception implements IErrorMessageException
{
    public function __construct()
    {
        parent::__construct('Full name columns cannot be used with First name or Last name columns');
    }
}