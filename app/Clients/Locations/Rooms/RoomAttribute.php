<?php
/**
 * Created by Justin McCombs.
 * Date: 12/3/15
 * Time: 4:54 PM
 */

namespace Pi\Clients\Locations\Rooms;


use Illuminate\Database\Eloquent\SoftDeletes;
use Pi\Auth\User;
use Pi\Clients\Client;
use Pi\Clients\Locations\Rooms\Room;
use Pi\Snippets\Interfaces\UsedInSnippetsInterface;

/**
 * Pi\Clients\Locations\Rooms\RoomAttribute
 *
 * @property integer $id
 * @property integer $client_id
 * @property integer $parent_room_attribute_id
 * @property string $name
 * @property string $snippet_key
 * @property string $default_value
 * @property boolean $is_required
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read mixed $uses_default_value
 * @property-read mixed $value
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Locations\Rooms\RoomAttribute whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Locations\Rooms\RoomAttribute whereClientId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Locations\Rooms\RoomAttribute whereParentRoomAttributeId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Locations\Rooms\RoomAttribute whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Locations\Rooms\RoomAttribute whereSnippetKey($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Locations\Rooms\RoomAttribute whereDefaultValue($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Locations\Rooms\RoomAttribute whereIsRequired($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Locations\Rooms\RoomAttribute whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Locations\Rooms\RoomAttribute whereUpdatedAt($value)
 */
class RoomAttribute extends \Eloquent implements UsedInSnippetsInterface {

    protected $guarded = ['id'];

    public static $rules = [
		'client_id' => 'required',
		'parent_room_attribute_id' => 'integer',
		'name' => 'required',
		'snippet_key' => 'string',
		'is_required' => 'boolean',
    ];

	public static $pivotRules = [
		'value' => 'required'
	];
    
    /*
	|--------------------------------------------------------------------------
	| Rules
	|--------------------------------------------------------------------------
	*/
	public static function rules($id = null, $merge=[])
	{
		return array_merge(self::$rules, $merge);
	}
    

    /*
	|--------------------------------------------------------------------------
	| Relationships
	|--------------------------------------------------------------------------
	*/


    /*
	|--------------------------------------------------------------------------
	| Getters and Setters
	|--------------------------------------------------------------------------
	*/
	/**
	 * Create a new Eloquent Collection instance.
	 *
	 * @param  array  $models
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function newCollection(array $models = [])
	{
		return new RoomAttributesCollection($models);
	}

	public function getUsesDefaultValueAttribute()
	{
		return !($this->pivot && $this->pivot->value);
	}

	public function getValueAttribute()
	{
		if ($this->pivot)
			return $this->pivot->value;

		return $this->default_value;
	}

	/*
    |--------------------------------------------------------------------------
    | Repo Methods
    |--------------------------------------------------------------------------
    | These methods may be moved to a repository later on in the development
    | cycle as needed.
    */

}