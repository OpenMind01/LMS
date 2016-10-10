<?php

namespace Pi\Http\Controllers;

use Pi\Clients\Theme\ThemesService;

class ThemeCssController extends Controller
{
    public function getIndex($themeId, ThemesService $themesService)
    {
        $theme = $themesService->get($themeId);

        return response(view('css.theme', [
                'theme' => $theme,
            ])->render(), 200)
            ->header('Content-Type', 'text/css')
            ->header('Cache-Control', 'max-age=30000000')
            ->header('Expires', $theme->updated_at->addYear()->toRfc1123String());
    }
}