<?php
/**
 * Created by Justin McCombs.
 * Date: 11/11/15
 * Time: 9:38 AM
 */

namespace Pi\DiscussionGroups\Traits;


use Pi\DiscussionGroups\DiscussionGroup;

trait OwnsDiscussionGroups
{

    public function discussionGroups()
    {
        return $this->morphMany(DiscussionGroup::class, 'discussionable');
    }

}