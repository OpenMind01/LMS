<?php

namespace Pi\Exceptions\Usergroups;

use Pi\Exceptions\IErrorMessageException;

class UsergroupCannotBeReadyException extends \Exception implements IErrorMessageException
{
    /**
     * InvalidArticleException constructor.
     */
    public function __construct()
    {
        parent::__construct('Ready User group should have modules and articles.');
    }
}