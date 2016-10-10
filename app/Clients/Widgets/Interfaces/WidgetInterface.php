<?php
/**
 * Created by Justin McCombs.
 * Date: 1/5/16
 * Time: 6:11 PM
 */

namespace Pi\Clients\Widgets\Interfaces;


use Pi\Auth\User;

interface WidgetInterface
{

    /**
     * This will set additional keys for the widget class
     * @param $key
     * @param $value
     * @return mixed
     */
    public function set($key, $value);

    /**
     * All widgets will require a user
     * @param User $user
     * @return mixed
     */
    public function setUser(User $user);

    /**
     * Returns the list of required keys and classnames
     * @return array
     */
    public function getRequiredKeys();

    /**
     * Returns an associative array
     * @return array
     */
    public function getData();

}