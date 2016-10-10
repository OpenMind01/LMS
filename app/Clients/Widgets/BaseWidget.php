<?php
/**
 * Created by Justin McCombs.
 * Date: 1/5/16
 * Time: 6:13 PM
 */

namespace Pi\Clients\Widgets;


use Pi\Auth\User;
use Pi\Clients\Widgets\Interfaces\WidgetInterface;

class BaseWidget implements WidgetInterface
{
    protected $user;

    protected $title = '';

    protected $description = '';

    protected $key = '';

    protected $requiredKeys = [];

    public function set($key, $value)
    {
        if (array_key_exists($key, $this->requiredKeys)
            && is_object($value)
            && get_class($value) == $this->requiredKeys[$key]
        ) {
            $this->$key = $value;
            return $this;
        }

        throw new \Exception('The key ' . $key . ' either does not exist in this widget or is not the correct class.');
    }

    public function setUser(User $user)
    {
        $this->user = $user;
        return $this;
    }

    public function getRequiredKeys()
    {
        return $this->requiredKeys;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getData()
    {
        if ( ! $this->user )
            throw new \Exception('No user was set for this widget.');

        foreach($this->requiredKeys as $key => $className) {
            if ( empty($this->$key) || !is_object($this->key) || get_class($this->$key) != $className)
                throw new \Exception("This widget is missing the required key '{$key}' with the classname of {$className}");
        }

        return ['user' => $this->user];
    }
}