<?php

namespace Pi\Exceptions\Milestones;

use Pi\Exceptions\IErrorMessageException;

class InvalidAssignableType extends \Exception implements IErrorMessageException
{
    /**
     * InvalidAssignableType constructor.
     */
    public function __construct()
    {
        parent::__construct('Invalid assignable type');
    }
}