<?php

namespace Pi\Helpers;

class SlugHelper
{
    /**
     * @param string $title
     * @param string[] $existingSlugs
     * @return string
     */
    public static function generate($title, array $existingSlugs)
    {
        $pureSlug = str_slug($title);
        $slug = $pureSlug;
        $increment = 1;
        while(in_array($slug, $existingSlugs)) {
            $slug = $pureSlug . '-' . ($increment++);
        }
        return $slug;
    }
}