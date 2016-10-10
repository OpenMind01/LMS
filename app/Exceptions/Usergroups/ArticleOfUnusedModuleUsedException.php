<?php

namespace Pi\Exceptions\Usergroups;

use Pi\Exceptions\IErrorMessageException;

class ArticleOfUnusedModuleUsedException extends \Exception implements IErrorMessageException
{
    /**
     * ArticleOfUnusedModuleUsedException constructor.
     */
    public function __construct()
    {
        parent::__construct('Article of unused module used');
    }
}