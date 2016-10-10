<?php
/**
 * Created by Justin McCombs.
 * Date: 12/7/15
 * Time: 1:21 PM
 */

namespace Pi\Clients\Courses;


class ArticleTopic
{

    public $title;
    public $number;
    public $body;

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     * @return ArticleTopic
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param mixed $number
     * @return ArticleTopic
     */
    public function setNumber($number)
    {
        $this->number = $number;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param mixed $body
     * @return ArticleTopic
     */
    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }

}