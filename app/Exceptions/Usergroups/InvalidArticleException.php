<?php

namespace Pi\Exceptions\Usergroups;

use Pi\Exceptions\IErrorMessageException;

class InvalidArticleException extends \Exception implements IErrorMessageException
{
    /**
     * InvalidArticleException constructor.
     */
    public function __construct()
    {
        parent::__construct('Invalid article');
    }
}