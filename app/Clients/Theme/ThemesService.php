<?php

namespace Pi\Clients\Theme;

use Pi\Http\Requests\Clients\Theme\ClientThemeUpdateRequest;

class ThemesService
{
    public function create()
    {
        $clientTheme = new Theme();
        $clientTheme->font = 'Open Sans';
        $clientTheme->nav_color = '#888888';
        $clientTheme->back_color = '#32404e';
        $clientTheme->style_type = 'c';
        $clientTheme->style_name = 'theme-navy';

        $clientTheme->save();

        return $clientTheme;
    }

    /**
     * @param $id
     * @return Theme
     */
    public function get($id)
    {
        return Theme::findOrFail($id);
    }

    public function update(Theme $theme, ClientThemeUpdateRequest $request)
    {
        $theme->font = $request->getFont();
        //$theme->nav_color = $request->getNavColor();
        //$theme->back_color = $request->getBackColor();
        $theme->style_type = $request->getStyleType();
        $theme->style_name = $request->getStyleName();

        if($request->isLogoUploaded())
        {
            $theme->logo = $request->getLogo();
        }

        if($request->isBackgroundUploaded())
        {
            $theme->background = $request->getBackground();
        }

        $theme->background_offset = $request->background_offset;

        $theme->save();
    }
}