<?php
/**
 * Created by Justin McCombs.
 * Date: 12/3/15
 * Time: 4:53 PM
 */

namespace Pi\Clients\Locations\Buildings;


use Codesleeve\Stapler\ORM\EloquentTrait;
use Codesleeve\Stapler\ORM\StaplerableInterface;
use Illuminate\Database\Eloquent\SoftDeletes;
use Pi\Clients\Client;
use Pi\Clients\Locations\Rooms\Room;
use Pi\Auth\User;
use Pi\Domain\Model;

/**
 * Pi\Clients\Locations\Buildings\Building
 *
 * @property integer $id
 * @property integer $client_id
 * @property string $name
 * @property string $number
 * @property string $address_1
 * @property string $address_2
 * @property string $city
 * @property string $state
 * @property string $zip
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $emergency_route_file_name
 * @property integer $emergency_route_file_size
 * @property string $emergency_route_content_type
 * @property string $emergency_route_updated_at
 * @property-read Client $client
 * @property-read \Illuminate\Database\Eloquent\Collection|Room[] $rooms
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Locations\Buildings\Building whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Locations\Buildings\Building whereClientId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Locations\Buildings\Building whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Locations\Buildings\Building whereNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Locations\Buildings\Building whereAddress1($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Locations\Buildings\Building whereAddress2($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Locations\Buildings\Building whereCity($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Locations\Buildings\Building whereState($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Locations\Buildings\Building whereZip($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Locations\Buildings\Building whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Locations\Buildings\Building whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Locations\Buildings\Building whereEmergencyRouteFileName($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Locations\Buildings\Building whereEmergencyRouteFileSize($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Locations\Buildings\Building whereEmergencyRouteContentType($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Locations\Buildings\Building whereEmergencyRouteUpdatedAt($value)
 */
class Building extends Model implements StaplerableInterface
{
    use EloquentTrait;

    protected $guarded = ['id'];

    public static $rules = [
        'client_id' => 'required',
        'name' => 'string|required',
        'number' => 'string'
    ];

    public function __construct(array $attributes = [])
    {
        $this->hasAttachedFile('emergency_route');

        parent::__construct($attributes);
    }

    /**
     * @return bool
     */
    public function hasEmergencyRoute()
    {
        return $this->emergency_route->originalFilename() || $this->client->hasEmergencyRoute();
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

        return $this->client->getEmergencyRoute();
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

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function users()
    {
        return $this->hasManyThrough(User::class, Room::class);
    }

    /*
	|--------------------------------------------------------------------------
	| Getters and Setters
	|--------------------------------------------------------------------------
	*/


    /*
	|--------------------------------------------------------------------------
	| Repo Methods
	|--------------------------------------------------------------------------
    | These methods may be moved to a repository later on in the development
    | cycle as needed.
	*/

}
Building::deleting(function(Building $building) {
    $userIds = $building->users->lists('id')->toArray();
    User::whereIn('id', $userIds)->update(['room_id' => null]);
    $building->rooms()->delete();
});