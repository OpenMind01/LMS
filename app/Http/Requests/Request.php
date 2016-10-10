<?php

namespace Pi\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Pi\Constants;

abstract class Request extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    /**
     * @param string $fieldName
     * @param Carbon $default
     * @return Carbon
     */
    protected function getDateValue($fieldName, Carbon $default = null)
    {
        try {
            return Carbon::createFromFormat(Constants::getDateFormat(), $this->get($fieldName));
        } catch(\Exception $e) {
            return $default;
        }
    }

    /**
     * @param string $fieldName
     * @param Carbon $default
     * @return Carbon
     */
    protected function getTimeValue($fieldName, Carbon $default = null)
    {
        try {
            return Carbon::createFromFormat(Constants::getTimeFormat(), $this->get($fieldName));
        } catch(\Exception $e) {
            return $default;
        }
    }

    /**
     * @param string $fieldName
     * @param Carbon $default
     * @return Carbon
     */
    protected function getDateTimeValue($fieldName, Carbon $default = null)
    {
        try {
            return Carbon::createFromFormat(Constants::getDateTimeFormat(), $this->get($fieldName));
        } catch(\Exception $e) {
            return $default;
        }
    }
}
