<?php

namespace Pi\Exceptions\Clients;

use Pi\Exceptions\IErrorMessageException;

class ExistingSlugException extends \Exception implements IErrorMessageException
{
    public function __construct($slug)
    {
        parent::__construct('Client with this slug already exists: ' . $slug);
    }
}