<?php

namespace Pi\Http\Requests\Clients\Settings;

use Pi\Http\Requests\Request;

class WidgetStoreRequest extends Request
{
    public function rules()
    {
        return [
            'widget_settings' => 'required'
        ];
    }

    /**
     * @return array
     */
    public function getWidgetSettings()
    {
        $res = json_decode($this->get('widget_settings'), true);
        return $res != null ? $res : [];
    }
}