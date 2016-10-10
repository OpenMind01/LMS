<?php

namespace Pi\Http\Requests\Clients\Meetings;

use Pi\Constants;
use Pi\Http\Requests\Request;

class QueryAvailableMeetingTimesRequest extends Request
{
    public function rules()
    {
        return [
            'date' => 'date_format:' . Constants::getDateFormat()
        ];
    }

    /**
     * @return bool
     */
    public function hasDate()
    {
        return $this->has('date');
    }

    /**
     * @return \Carbon\Carbon
     */
    public function getDate()
    {
        return $this->getDateValue('date');
    }
}