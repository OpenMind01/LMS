<?php

namespace Pi\Clients\LessonStyles;

use Pi\Domain\Model;

use Codesleeve\Stapler\ORM\StaplerableInterface;
use Codesleeve\Stapler\ORM\EloquentTrait;


/**
 * Pi\Clients\LessonStyles\LessonStyles
 */
class LessonStyles extends Model implements StaplerableInterface
{
    use EloquentTrait;

    public function __construct()
    {
    }

}