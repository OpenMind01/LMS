<?php
/**
 * Created by PhpStorm.
 * User: justinmccombs
 * Date: 8/6/14
 * Time: 1:04 PM
 */

namespace Pi\Auth\Impersonation;

use \Session;
use Pi\Auth\User;

class Impersonate implements ImpersonateInterface{

    protected $user;

    protected $key = 'impersonate.original_user_id';

    public function __construct()
    {
        $this->user = \Auth::user();
    }

    public function switchTo($id)
    {
        if( $this->user->isSuperAdmin()) {
            $this->storeOriginalUserId($this->user->id);
            $user = User::findOrFail($id);
            \Auth::loginUsingId($id);
        }
    }

    public function switchBack()
    {
        if ($originalId = $this->getOriginalUserId())
        {
            $user = User::findOrFail($originalId);
            $this->destroy();
            \Auth::login($user);
        }
    }

    public function isImpersonating()
    {
        return (Session::has($this->key));
    }

    public function getOriginalUserId()
    {
        $userId = Session::get($this->key);
        $this->destroy();
        return $userId;
    }

    function storeOriginalUserId($id)
    {
        if ( !Session::has($this->key))
            Session::put($this->key, $id);
    }

    public function destroy()
    {
        Session::forget($this->key);
    }
}

\Event::listen('UserIsLoggingOut', function($event) {
    (new Impersonate())->destroy();
});