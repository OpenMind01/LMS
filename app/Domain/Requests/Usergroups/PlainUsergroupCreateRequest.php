<?php

namespace Pi\Domain\Requests\Usergroups;

class PlainUsergroupCreateRequest implements IUsergroupCreateRequest
{
    private $title;

    private $courseId;

    public function __construct($title, $courseId)
    {
        $this->title = $title;
        $this->courseId = $courseId;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return int
     */
    public function getCourseId()
    {
        return $this->courseId;
    }
}