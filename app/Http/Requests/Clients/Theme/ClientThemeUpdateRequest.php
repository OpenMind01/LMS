<?php

namespace Pi\Http\Requests\Clients\Theme;

use Pi\Clients\Theme\Theme;
use Pi\Http\Requests\Request;

class ClientThemeUpdateRequest extends Request
{
    public function rules()
    {
        return [
            'font' => 'required|in:' . join(',', array_keys(Theme::getAvailableFonts())),
            //'nav_color' => 'required',
            //'back_color' => 'required',
            'style_type' => 'required|in:a,b,c',
            'style_name' => 'required',
        ];
    }

    public function getFont()
    {
        return $this->get('font');
    }

    public function getNavColor()
    {
        return $this->get('nav_color');
    }

    public function getBackColor()
    {
        return $this->get('back_color');
    }

    public function getStyleType()
    {
        return $this->get('style_type');
    }

    public function getStyleName()
    {
        return $this->get('style_name');
    }

    public function isLogoUploaded()
    {
        return $this->hasFile('logo');
    }

    public function getLogo()
    {
        return $this->file('logo');
    }

    public function isBackgroundUploaded()
    {
        return $this->hasFile('background');
    }

    public function getBackground()
    {
        return $this->file('background');
    }
}