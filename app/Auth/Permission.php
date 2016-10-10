<?php
/**
 * Created by Justin McCombs.
 * Date: 9/28/15
 * Time: 5:19 PM
 */

namespace Pi\Auth;

class Permission {
    const USERS_MANAGE = 'users.manage';

    const CLIENTS_MANAGE = 'clients.manage';
    const CLIENT_USERGROUPS_MANAGE = 'client.usergroups.manage';

    const MILESTONES_MANAGE = 'milestones.manage';
    const MILESTONES_SHOW = 'milestones.show';

    const INDUSTRIES_MANAGE = 'industries.manage';
    const USERGROUPS_MANAGE = 'usergroups.manage';
    const EVENTS_MANAGE = 'events.manage';

    const DISCUSSION_GROUPS_MANAGE = 'discussiongroups.manage';
    const THREAD_RAISE_HAND = 'threads.raise_hand';
}
