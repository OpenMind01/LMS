<?php

namespace Pi\Http\Requests\Milestones;

use Carbon\Carbon;
use Pi\Clients\Milestones\Milestone;
use Pi\Http\Requests\Request;

class MilestoneCreateRequest extends Request
{
    public function rules()
    {
        return [
            'title' => 'required',
            'finish_at' => 'required|date',
            'assignable_type' => 'required|in:' . join(',', [Milestone::ASSIGNABLE_TYPE_CLIENT, Milestone::ASSIGNABLE_TYPE_USERGROUP])
        ];
    }

    public function getTitle()
    {
        return $this->get('title');
    }

    public function getCourseId()
    {
        return $this->get('course_id');
    }

    /**
     * @return Carbon
     */
    public function getFinishDate()
    {
        return $this->getDateValue('finish_at');
    }

    public function getAssignableType()
    {
        return $this->get('assignable_type');
    }

    public function getUsergroupId()
    {
        return $this->get('usergroup_id');
    }
}