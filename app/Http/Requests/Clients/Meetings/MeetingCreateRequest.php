<?php

namespace Pi\Http\Requests\Clients\Meetings;

use Carbon\Carbon;
use Pi\Constants;
use Pi\Http\Requests\Request;

class MeetingCreateRequest extends Request
{
    public function rules()
    {
        return [
            'meeting_date' => 'required|date_format:' . Constants::getDateFormat(),
            'meeting_time' => 'required|date_format:' . Constants::getTimeFormat(),
            'reason' => 'required',
        ];
    }

    /**
     * @return Carbon
     */
    public function getDateTime()
    {
        $date = $this->getDateValue('meeting_date');
        $time = $this->getTimeValue('meeting_time');

        return Carbon::create($date->year, $date->month, $date->day, $time->hour, $time->minute, 0);
    }

    /**
     * @return string
     */
    public function getReason()
    {
        return $this->get('reason');
    }
}