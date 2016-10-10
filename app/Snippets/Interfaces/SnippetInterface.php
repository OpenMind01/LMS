<?php
/**
 * Created by Justin McCombs.
 * Date: 10/7/15
 * Time: 11:04 AM
 */

namespace Pi\Snippets\Interfaces;


interface SnippetInterface
{

    /**
     * Returns the class name of the main model used in this snippet
     * @return string
     */
    public function getClass();

    /**
     * Returns the shortcode for the snippet
     *
     * @return string
     */
    public function getShortcode();

    /**
     * Returns a description of the snippet
     * @return mixed
     */
    public function getDescription();

    /**
     * Returns the value to be used in the snippet
     * @return mixed
     */
    public function getValue();

    /**
     * Returns whether or not the snippet should be escaped
     * @return bool
     */
    public function shouldEscapeValue();

    /**
     * Sets the instance to be used in generating the value of the snippet
     * @param UsedInSnippetsInterface $instance
     * @return $this
     */
    public function setInstance(UsedInSnippetsInterface $instance);



    /**
     * Returns a list of required keys to set with the set(); method
     * @return array
     */
    public function getRequiredKeys();

    /**
     * Sets any additional information that must be used in the snippet.
     * @param $key
     * @param $value
     * @return $this
     */
    public function set($key, $value);

}