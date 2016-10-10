<?php
/**
 * Created by Justin McCombs.
 * Date: 9/28/15
 * Time: 5:19 PM
 */

namespace Pi\Auth;

class Role {
    const SUPER_ADMIN = 'superadmin';
    const ADMIN = 'admin';
    const MODERATOR = 'moderator';
    const STUDENT = 'student';

    /**
     * @return string[]
     */
    public static function getAllRoles()
    {
        return [self::STUDENT, self::MODERATOR, self::ADMIN, self::SUPER_ADMIN];
    }
}