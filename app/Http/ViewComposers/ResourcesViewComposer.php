<?php
/**
 * Created by Justin McCombs.
 * Date: 11/11/15
 * Time: 1:48 PM
 */

namespace Pi\Http\ViewComposers;


use Illuminate\View\View;
use Pi\Clients\Resources\ResourceCollection;
use Pi\Clients\Resources\Interfaces\HasResourcesInterface;

class ResourcesViewComposer
{

    public function compose(View $view)
    {
        $resources = new ResourceCollection;
        foreach($view->getData() as $key => $value)
        {
            // If the item is not an object, it will not have any
            // resources attached to it.
            if ( !is_object($value) ) continue;

            $interfaces = class_implements($value);
            if(in_array(HasResourcesInterface::class, $interfaces)) {
                $value->load('resources');
                $resources = $resources->merge($value->resources);
            }
        }

        $view->with('resources', $resources);
    }

}