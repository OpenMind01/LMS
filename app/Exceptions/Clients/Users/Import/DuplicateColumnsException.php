<?php

namespace Pi\Exceptions\Clients\Users\Import;

use Pi\Exceptions\IErrorMessageException;

class DuplicateColumnsException extends \Exception implements IErrorMessageException
{
    public function __construct()
    {
        parent::__construct('Duplicate columns are not allowed');
    }
}