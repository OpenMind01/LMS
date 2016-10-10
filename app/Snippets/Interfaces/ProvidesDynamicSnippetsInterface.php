<?php
/**
 * Created by Justin McCombs.
 * Date: 12/3/15
 * Time: 4:59 PM
 */

namespace Pi\Snippets\Interfaces;

use Pi\Auth\User;

interface ProvidesDynamicSnippetsInterface
{
    public function getSnippetsForUser(User $user);
}