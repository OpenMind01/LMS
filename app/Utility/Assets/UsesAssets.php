<?php
/**
 * Created by Justin McCombs.
 * Date: 10/20/15
 * Time: 12:16 PM
 */

namespace Pi\Utility\Assets;


trait UsesAssets
{

    /**
     * @return mixed
     */
    public function assets()
    {
        return $this->morphMany(Asset::class, 'assetable');
    }

}