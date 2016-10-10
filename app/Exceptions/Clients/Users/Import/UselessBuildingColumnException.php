<?php

namespace Pi\Exceptions\Clients\Users\Import;

use Pi\Exceptions\IErrorMessageException;

class UselessBuildingColumnException extends \Exception implements IErrorMessageException
{
    public function __construct()
    {
        parent::__construct('Building column is useless without room column');
    }
}