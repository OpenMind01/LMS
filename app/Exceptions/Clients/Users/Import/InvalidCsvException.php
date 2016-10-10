<?php

namespace Pi\Exceptions\Clients\Users\Import;

use Pi\Exceptions\IErrorMessageException;

class InvalidCsvException extends \Exception implements IErrorMessageException
{
    public function __construct()
    {
        parent::__construct('Invalid or empty .csv file');
    }
}