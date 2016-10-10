<?php

namespace Pi\Http\Requests\Industries;

use Pi\Http\Requests\Request;

class IndustryCreateRequest extends Request
{
    public function rules()
    {
        return [
            'title' => 'required|unique:industries'
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
     * @return bool
     */
    public function getReady()
    {
        return $this->has('ready');
    }

    /**
     * @return int[]
     */
    public function getUsergroups()
    {
        return $this->get('usergroups', []);
    }
}