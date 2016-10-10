<?php

namespace Pi\Http\Requests\Clients\Courses;

use Pi\Http\Requests\Request;

class CourseCloneRequest extends Request
{
    public function rules()
    {
        return [
            'name' => 'required',
        ];
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->get('name');
    }

    /**
     * @return string
     */
    public function getClientId()
    {
        return $this->get('client_id');
    }
}