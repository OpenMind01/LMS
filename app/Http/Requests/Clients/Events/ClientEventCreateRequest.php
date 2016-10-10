<?php

namespace Pi\Http\Requests\Clients\Events;

use Carbon\Carbon;
use Pi\Clients\Milestones\Milestone;
use Pi\Constants;
use Pi\Http\Requests\Request;

class ClientEventCreateRequest extends Request
{
    public function rules()
    {
        return [
            'title' => 'required',
            'string_start_datetime' => 'required|date_format:' . Constants::getDateTimeFormat(),
            'string_finish_datetime' => 'required_without:all_day|date_format:' . Constants::getDateTimeFormat(),
        ];
    }

    public function getTitle()
    {
        return $this->get('title');
    }

    public function getText()
    {
        return $this->get('text');
    }

    /**
     * @return Carbon
     */
    public function getStartDateTime()
    {
        return $this->getDateTimeValue('string_start_datetime');
    }

    /**
     * @return bool
     */
    public function getAllDay()
    {
        return $this->has('all_day');
    }

    /**
     * @return Carbon
     */
    public function getFinishDateTime()
    {
        return $this->getDateTimeValue('string_finish_datetime');
    }
}