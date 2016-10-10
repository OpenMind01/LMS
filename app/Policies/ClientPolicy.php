<?php

namespace Pi\Policies;

use Pi\Auth\User;
use Pi\Clients\Client;

class ClientPolicy {
  /**
   * Create a new policy instance.
   *
   * @return void
   */
  public function __construct() {
    //
  }

  public function show(User $user, Client $client) {
    if ($user->isSuperAdmin()) {
      return TRUE;
    }

    return ($user->client_id == $client->id);
  }

  public function manage(User $user, Client $client) {
    // return ($user->isSuperAdmin());
    // return $user->isModerator($client);
    return $user->isSuperAdmin();
  }

  public function member(User $user, Client $client) {
    if ($user->isSuperAdmin()) {
      return TRUE;
    }
    return $user->client_id == $client->id;
  }

  public function assign(User $user, $client) {
    //return ($user->isSuperAdmin());
    return $user->isModerator($client);
  }

  public function manageMilestones(User $user, Client $client) {
    return $user->isModerator($client);
  }

  public function manageEvents(User $user, Client $client) {
    return $user->isModerator($client);
  }

  public function activate(User $user, Client $client) {
    return $user->isSuperAdmin() || $client->isOwner($user);
  }

  /**
   * Decides can user schedule meeting with administrator
   *
   * @param User $user
   * @param Client $client
   * @return bool
   */
  public function scheduleMeeting(User $user, Client $client) {
    return $user->isAdmin();
  }
}
