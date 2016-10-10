<?php

namespace Pi\Exceptions\Clients\Users\Import;

use Pi\Exceptions\IErrorMessageException;

class RoomAndNoBuildingsException extends \Exception implements IErrorMessageException
{
    public function __construct()
    {
        parent::__construct('Client don\'t have buildings. Room column cannot be used.');
    }
}