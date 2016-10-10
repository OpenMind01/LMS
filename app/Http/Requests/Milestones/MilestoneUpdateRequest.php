<?php

namespace Pi\Http\Requests\Milestones;

use Carbon\Carbon;
use Pi\Clients\Milestones\Milestone;
use Pi\Http\Requests\Request;

class MilestoneUpdateRequest extends Request
{
    public function rules()
    {
        return [
            'title' => 'required',
            'string_finish_datetime' => 'required|date',
        ];
    }

    public function getTitle()
    {
        return $this->get('title');
    }

    /**
     * @return Carbon
     */
    public function getFinishDate()
    {
        return $this->getDateValue('string_finish_datetime');
    }
}