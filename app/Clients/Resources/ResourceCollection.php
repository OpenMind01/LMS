<?php
/**
 * Created by Justin McCombs.
 * Date: 11/11/15
 * Time: 1:49 PM
 */

namespace Pi\Clients\Resources;


use Illuminate\Database\Eloquent\Collection;

class ResourceCollection extends Collection
{

    protected $types;

    public function __construct(array $models = [])
    {
        $this->types = Resource::$types;
        parent::__construct($models);
    }

    public function getTypes()
    {
        return $this->types;
    }

    public function nameForType($type)
    {
        if ( ! array_key_exists($type, $this->types))
            throw new \Exception('The file type with an index of ' . $type . ' could not be found.');
        return $this->types[$type];
    }

    public function ofType($type)
    {
        if ( ! array_key_exists($type, $this->types))
            throw new \Exception('The file type with an index of ' . $type . ' could not be found.');

        return $this->filter(function(Resource $resource) use($type) {
            return ($resource->type == $type);
        });
    }

}