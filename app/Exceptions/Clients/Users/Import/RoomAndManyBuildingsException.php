<?php

namespace Pi\Exceptions\Clients\Users\Import;

use Pi\Exceptions\IErrorMessageException;

class RoomAndManyBuildingsException extends \Exception implements IErrorMessageException
{
    public function __construct()
    {
        parent::__construct('There are many buildings for this client. Building column with Building names required.');
    }
}