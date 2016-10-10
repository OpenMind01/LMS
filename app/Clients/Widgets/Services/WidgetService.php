<?php
/**
 * Created by Justin McCombs.
 * Date: 1/5/16
 * Time: 6:25 PM
 */

namespace Pi\Clients\Widgets\Services;


use Pi\Auth\Role;
use Pi\Auth\User;
use Pi\Clients\Widgets\Roles\Student\StudentCourseOverview;
use Pi\Clients\Widgets\Roles\SuperAdmin\ClientOverviewWidget;

class WidgetService
{

    /**
     * @var User
     */
    protected $user;

    /**
     * @var array
     */
    protected $classMap = [];

    public function __construct()
    {
        $this->classMap = [
            Role::SUPER_ADMIN => [
                new ClientOverviewWidget,
            ],
            Role::ADMIN => [],
            Role::MODERATOR => [],
            Role::STUDENT => [
                new StudentCourseOverview
            ],
        ];
    }
    /**
     * Sets the user on the class.
     * @param User $user
     * @return $this
     */
    public function setUser(User $user) {
        $this->user = $user;
        return $this;
    }

    /**
     * Trows an exception if the user is not set.  this is called from methods which require a user
     * @throws \Exception
     */
    protected function checkUser()
    {
        if ( ! $this->user )
            throw new \Exception('You must set a user on the WidgetService before using this method.');
    }

    public function getAvailableWidgets()
    {
        $this->checkUser();

        $role = $this->user->role;

        if ( array_key_exists($role, $this->classMap))
            return $this->classMap[$role];

        return [];
    }

    public function getWidgetData($widgetKey, $requiredKeyValues = [])
    {
        foreach($this->getAvailableWidgets() as $widget) {
            if ($widget->key == $widgetKey) {
                // If the widget has required keys, set them and make sure they have all of them.
                if (count($widget->getRequiredKeys())) {
                    foreach($requiredKeyValues as $key => $value) {
                        $widget->set($key, $value);
                    }
                }

                return $widget->getData();
            }
        }

        throw new \Exception('The widget key passed to this method does not exist for the user type of user ' . $this->user->id);
    }

}