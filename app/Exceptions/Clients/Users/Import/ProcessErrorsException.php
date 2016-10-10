<?php

namespace Pi\Exceptions\Clients\Users\Import;

use Pi\Exceptions\IErrorMessageException;

class ProcessErrorsException extends \Exception implements IErrorMessageException
{
    public function __construct(array $errors)
    {
        parent::__construct(join("\n", $errors));
    }
}