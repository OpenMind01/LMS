<?php

namespace Pi\Services;

class BreadcrumbsService
{
    /**
     * @var Breadcrumb[]
     */
    private static $items = [];

    public function add($url, $title)
    {
        self::$items[] = new Breadcrumb($url, $title);
    }

    /**
     * Returns the title of the last breadcrumb. Usually this value uses as a page title.
     *
     * @return string
     */
    public function getTitle()
    {
        if(count(self::$items) == 0) return '';

        return self::$items[count(self::$items) - 1]->getTitle();
    }

    /**
     * Returns all breadcrumbs except the last one.
     *
     * @return Breadcrumb[]
     */
    public function getBreadcrumbs()
    {
        return array_slice(self::$items, 0, count(self::$items) - 1);
    }

    /**
     * @return bool
     */
    public function hasItems()
    {
        return !empty(self::$items);
    }
}

class Breadcrumb
{
    private $url;
    private $title;

    public function __construct($url, $title)
    {
        $this->url = $url;
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
}