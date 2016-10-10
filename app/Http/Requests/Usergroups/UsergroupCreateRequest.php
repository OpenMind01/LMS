<?php

namespace Pi\Http\Requests\Usergroups;

use Pi\Domain\Requests\Usergroups\IUsergroupCreateRequest;
use Pi\Http\Requests\Request;

class UsergroupCreateRequest extends Request implements IUsergroupCreateRequest
{
    public function rules()
    {
        return [
            'title' => 'required',
            'course_id' => 'required'
        ];
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->get('title');
    }

    /**
     * @return int
     */
    public function getCourseId()
    {
        return $this->get('course_id');
    }
}