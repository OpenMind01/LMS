<?php

namespace Pi\Exceptions\Clients\Courses;

use Pi\Exceptions\IErrorMessageException;

class UserAlreadyAssignedException extends \Exception implements IErrorMessageException
{
    public function __construct()
    {
        parent::__construct("User already assigned to this course");
    }
}