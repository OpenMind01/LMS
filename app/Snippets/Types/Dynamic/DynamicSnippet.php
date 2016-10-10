<?php
/**
 * Created by Justin McCombs.
 * Date: 12/3/15
 * Time: 5:02 PM
 */

namespace Pi\Snippets\Types\Dynamic;


use Pi\Snippets\Interfaces\SnippetInterface;
use Pi\Snippets\Interfaces\UsedInSnippetsInterface;
use Pi\Snippets\Types\Snippet;

class DynamicSnippet extends Snippet
{

    public $class;
    public $shortCode;
    public $description;
    public $requiredKeys;
    public $value;
    public $instance;

    /**
     * @param mixed $class
     * @return DynamicSnippet
     */
    public function setClass($class)
    {
        $this->class = $class;
        return $this;
    }

    /**
     * @param mixed $shortCode
     * @return DynamicSnippet
     */
    public function setShortCode($shortCode)
    {
        $this->shortCode = $shortCode;
        return $this;
    }

    /**
     * @param mixed $description
     * @return DynamicSnippet
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @param mixed $requiredKeys
     * @return DynamicSnippet
     */
    public function setRequiredKeys($requiredKeys)
    {
        $this->requiredKeys = $requiredKeys;
        return $this;
    }

    /**
     * @param mixed $value
     * @return DynamicSnippet
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }



    /**
     * Returns the class name of the main model used in this snippet
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * Returns the shortcode for the snippet
     *
     * @return string
     */
    public function getShortcode()
    {
        return $this->shortCode;
    }

    /**
     * Returns a description of the snippet
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Returns the value to be used in the snippet
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Sets the instance to be used in generating the value of the snippet
     * @param UsedInSnippetsInterface $instance
     * @return $this
     */
    public function setInstance(UsedInSnippetsInterface $instance)
    {
        $this->instance = $instance;
        return $this;
    }

    /**
     * Returns a list of required keys to set with the set(); method
     * @return array
     */
    public function getRequiredKeys()
    {
        return $this->requiredKeys;
    }

    /**
     * Sets any additional information that must be used in the snippet.
     * @param $key
     * @param $value
     * @return $this
     */
    public function set($key, $value)
    {
        $this->$key = $value;
        return $this;
    }
}