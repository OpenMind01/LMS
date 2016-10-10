<?php

namespace Pi\Events\Users;

use Pi\Auth\User;
use Pi\Events\Event;
use Illuminate\Queue\SerializesModels;

class UserCreated extends Event
{
    use SerializesModels;

    /**
     * @var User
     */
    private $user;

    /**
     * @var string
     */
    private $password;

    public function __construct(User $user, $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }
}
