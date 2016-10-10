<?php
/**
 * Created by Justin McCombs.
 * Date: 12/7/15
 * Time: 9:49 AM
 */

namespace Pi\Clients\Locations\Rooms;


use Illuminate\Database\Eloquent\Collection;

class RoomAttributesCollection extends Collection
{

    public function getTree()
    {
        return $this;
    }

    public function getValueForAttributeId($attributeId)
    {
        foreach($this as $attribute)
        {
            if ($attribute->id == $attributeId && $attribute->pivot)
                return $attribute->pivot->value;
        }

        return null;
    }

}