<?php
/**
 * Created by Justin McCombs.
 * Date: 11/11/15
 * Time: 1:55 PM
 */

namespace Pi\Clients\Resources\Traits;

use Pi\Clients\Resources\Resource;

trait HasResources
{

    public function resources()
    {
        return $this->morphMany(Resource::class, 'resourceable');
    }

}