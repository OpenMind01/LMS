<?php

namespace Pi\Http\Requests\Usergroups;

use Pi\Http\Requests\Request;

class UsergroupUpdateRequest extends Request
{
    public function rules()
    {
        return [
            'title' => 'required',
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
    public function getModules()
    {
        if(!$this->has('modules')) return [];

        return array_keys($this->get('modules'));
    }

    /**
     * @return int[]
     */
    public function getArticles()
    {
        if(!$this->has('articles')) return [];

        return array_keys($this->get('articles'));
    }

    /**
     * @return int[]
     */
    public function getIndustries()
    {
        return $this->get('industries', []);
    }
}