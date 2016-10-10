<?php
/**
 * Created by Justin McCombs.
 * Date: 12/3/15
 * Time: 4:53 PM
 */

namespace Pi\Clients\Locations\Rooms;


use Codesleeve\Stapler\ORM\EloquentTrait;
use Codesleeve\Stapler\ORM\StaplerableInterface;
use Pi\Clients\Locations\Rooms\RoomAttribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use Pi\Auth\User;
use Pi\Clients\Client;
use Pi\Clients\Locations\Buildings\Building;
use Pi\Domain\Model;

/**
 * Pi\Clients\Locations\Rooms\Room
 *
 * @property integer $id
 * @property integer $client_id
 * @property integer $building_id
 * @property string $number
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $emergency_route_file_name
 * @property integer $emergency_route_file_size
 * @property string $emergency_route_content_type
 * @property string $emergency_route_updated_at
 * @property-read Client $client
 * @property-read Building $building
 * @property-read \Illuminate\Database\Eloquent\Collection|User[] $users
 * @property-read \Illuminate\Database\Eloquent\Collection|RoomAttribute[] $roomAttributes
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Locations\Rooms\Room whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Locations\Rooms\Room whereClientId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Locations\Rooms\Room whereBuildingId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Locations\Rooms\Room whereNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Locations\Rooms\Room whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Locations\Rooms\Room whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Locations\Rooms\Room whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Locations\Rooms\Room whereEmergencyRouteFileName($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Locations\Rooms\Room whereEmergencyRouteFileSize($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Locations\Rooms\Room whereEmergencyRouteContentType($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Locations\Rooms\Room whereEmergencyRouteUpdatedAt($value)
 */
class Room extends Model implements StaplerableInterface
{
    use EloquentTrait;

    protected $guarded = ['id'];

    public static $rules = [

    ];

    public function __construct(array $attributes = [])
    {
        $this->hasAttachedFile('emergency_route');

        parent::__construct($attributes);
    }
    
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
	public function client()
	{
		return $this->belongsTo(Client::class);
	}

	public function building()
	{
		return $this->belongsTo(Building::class);
	}

	public function users()
	{
		return $this->hasMany(User::class);
	}

	public function roomAttributes()
	{
		return $this->belongsToMany(RoomAttribute::class, 'room_attribute_room')->withPivot([
			'value', 'client_id'
		])->withTimestamps();
	}

    /*
	|--------------------------------------------------------------------------
	| Getters and Setters
	|--------------------------------------------------------------------------
	*/

    /**
     * @return bool
     */
    public function hasEmergencyRoute()
    {
        return $this->emergency_route->originalFilename() || $this->building->hasEmergencyRoute();
    }

    /**
     * @return \Codesleeve\Stapler\Attachment
     */
    public function getEmergencyRoute()
    {
        if($this->emergency_route->originalFilename())
        {
            return $this->emergency_route;
        }

        return $this->building->getEmergencyRoute();
    }

    /*
	|--------------------------------------------------------------------------
	| Repo Methods
	|--------------------------------------------------------------------------
    | These methods may be moved to a repository later on in the development
    | cycle as needed.
	*/

}
Room::deleting(function(Room $room) {
	User::where('room_id', '=', $room->id)->update(['room_id' => null]);
	$room->roomAttributes()->sync([]);
});