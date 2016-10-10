<?php
namespace Pi\Domain\Requests\Usergroups;

interface IUsergroupCreateRequest
{
    /**
     * @return string
     */
    public function getTitle();

    /**
     * @return int
     */
    public function getCourseId();
}