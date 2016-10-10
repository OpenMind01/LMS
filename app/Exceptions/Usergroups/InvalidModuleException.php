<?php

namespace Pi\Exceptions\Usergroups;

use Pi\Exceptions\IErrorMessageException;

class InvalidModuleException extends \Exception implements IErrorMessageException
{
    /**
     * InvalidModuleException constructor.
     */
    public function __construct()
    {
        parent::__construct('Invalid module');
    }
}