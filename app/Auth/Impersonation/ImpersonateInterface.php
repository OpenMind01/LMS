<?php
/**
 * Created by PhpStorm.
 * User: justinmccombs
 * Date: 8/6/14
 * Time: 1:04 PM
 */

namespace Pi\Auth\Impersonation;


interface ImpersonateInterface {

    /**
     * Performs permissions check and switches current user out with
     * another user by id
     *
     * @param $id
     * @return mixed
     */
    public function switchTo($id);

    /**
     * If the current user is impersonating another user, this reverts
     * their state back to their own login
     *
     */
    public function switchBack();

    /**
     * Is the logged in user being impersonated?
     *
     * @return bool
     */
    public function isImpersonating();

    /**
     * Returns the stored id of the original user
     *
     * @return int
     */
    public function getOriginalUserId();

    /**
     * Stores the original users ID in order to exit the impersonation
     *
     * @param $id
     * @return int
     */
    public function storeOriginalUserId($id);

} 