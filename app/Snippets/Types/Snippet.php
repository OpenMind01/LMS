<?php
/**
 * Created by Justin McCombs.
 * Date: 10/14/15
 * Time: 10:46 AM
 */

namespace Pi\Snippets\Types;


use Pi\Snippets\Interfaces\SnippetInterface;
use Pi\Snippets\Interfaces\UsedInSnippetsInterface;

abstract class Snippet implements SnippetInterface
{

    public $class;
    public $requiredKeys;
    public $shortCode;
    public $description;
    public $instance;

    /**
     * @return mixed
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param mixed $class
     * @return Snippet
     */
    public function setClass($class)
    {
        $this->class = $class;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRequiredKeys()
    {
        return $this->requiredKeys;
    }

    /**
     * @param mixed $requiredKeys
     * @return Snippet
     */
    public function setRequiredKeys($requiredKeys)
    {
        $this->requiredKeys = $requiredKeys;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getShortCode()
    {
        return $this->shortCode;
    }

    /**
     * @param mixed $shortCode
     * @return Snippet
     */
    public function setShortCode($shortCode)
    {
        $this->shortCode = $shortCode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     * @return Snippet
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getInstance()
    {
        return $this->instance;
    }

    /**
     * @param UsedInSnippetsInterface $instance
     * @return $this
     */
    public function setInstance(UsedInSnippetsInterface $instance)
    {
        $this->instance = $instance;
        return $this;
    }

    public function set($key, $value)
    {
        $this->$key = $value;
        return $this;
    }

    public function toArray()
    {
        return [
            'class' => $this->getClass(),
            'requiredClasses' => $this->getRequiredKeys(),
            'shortcode' => $this->getShortcode(),
            'description' => $this->getDescription(),
            'instance' => $this->getInstance(),
        ];
    }

    public function toJson()
    {
        return [
            'class' => $this->getClass(),
            'requiredClasses' => $this->getRequiredKeys(),
            'shortcode' => $this->getShortcode(),
            'description' => $this->getDescription(),
            'instance' => $this->getInstance(),
        ];
    }

    /**
     * Returns whether or not the snippet should be escaped
     * @return bool
     */
    public function shouldEscapeValue()
    {
        return true;
    }

}