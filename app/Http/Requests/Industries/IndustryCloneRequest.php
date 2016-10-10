<?php

namespace Pi\Http\Requests\Industries;

use Pi\Http\Requests\Request;

class IndustryCloneRequest extends Request
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
}