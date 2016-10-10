<?php

namespace Pi\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Pi\Auth\User;
use Pi\Clients\Client;
use Pi\Clients\Resources\Resource;

class ResourcePolicy {
  use HandlesAuthorization;

  /**
   * Create a new policy instance.
   *
   * @return void
   */
  public function __construct() {
    //
  }

  public function manage(User $user, Resource $resource, Client $client) {
    // return TRUE;
    return $user->isAdmin();
  }
}
