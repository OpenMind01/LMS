<?php
/**
 * Created by Justin McCombs.
 * Date: 9/28/15
 * Time: 5:45 PM
 */

namespace Pi\Clients;


use Codesleeve\Stapler\ORM\EloquentTrait;
use Codesleeve\Stapler\ORM\StaplerableInterface;
use Pi\Clients\Locations\Rooms\RoomAttribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use Pi\Auth\User;
use Pi\Clients\Courses\Course;
use Pi\Clients\Locations\Buildings\Building;
use Pi\Clients\Locations\Rooms\Room;
use Pi\Clients\Milestones\Milestone;
use Pi\Clients\Courses\Module;
use Pi\Clients\Resources\Interfaces\HasResourcesInterface;
use Pi\Clients\Theme\Theme;
use Pi\Clients\Usergroups\ClientUsergroup;
use Pi\Clients\Resources\Traits\HasResources;
use Pi\DiscussionGroups\Interfaces\OwnsDiscussionGroupsInterface;
use Pi\DiscussionGroups\Traits\OwnsDiscussionGroups;
use Pi\Constants;
use Pi\Domain\Industries\Industry;
use Pi\Domain\Model;
use Pi\Usergroups\Usergroup;
use Pi\Snippets\Interfaces\UsedInSnippetsInterface;

/**
 * Pi\Clients\Client
 *
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property integer $owner_id
 * @property string $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property boolean $active
 * @property integer $theme_id
 * @property integer $administrator_id
 * @property string $emergency_route_file_name
 * @property integer $emergency_route_file_size
 * @property string $emergency_route_content_type
 * @property string $emergency_route_updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|User[] $users
 * @property-read \Illuminate\Database\Eloquent\Collection|Industry[] $industries
 * @property-read User $administrator
 * @property-read \Illuminate\Database\Eloquent\Collection|Course[] $courses
 * @property-read \Illuminate\Database\Eloquent\Collection|Milestone[] $milestones
 * @property-read \Illuminate\Database\Eloquent\Collection|Usergroup[] $usergroups
 * @property-read \Illuminate\Database\Eloquent\Collection|ClientUsergroup[] $innerUsergroups
 * @property-read \Illuminate\Database\Eloquent\Collection|Building[] $buildings
 * @property-read \Illuminate\Database\Eloquent\Collection|RoomAttribute[] $roomAttributes
 * @property-read Theme $theme
 * @property-read mixed $client_id
 * @property-read \Illuminate\Database\Eloquent\Collection|Resource[] $resources
 * @property-read \Illuminate\Database\Eloquent\Collection|DiscussionGroup[] $discussionGroups
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Client whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Client whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Client whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Client whereOwnerId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Client whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Client whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Client whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Client whereActive($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Client whereThemeId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Client whereAdministratorId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Client whereEmergencyRouteFileName($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Client whereEmergencyRouteFileSize($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Client whereEmergencyRouteContentType($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Client whereEmergencyRouteUpdatedAt($value)
 */
class Client extends Model implements UsedInSnippetsInterface, HasResourcesInterface, StaplerableInterface, OwnsDiscussionGroupsInterface {

    use EloquentTrait;
	use HasResources, OwnsDiscussionGroups;
//    use SoftDeletes;

    protected $guarded = ['id'];

    public static $rules = [
		'name' => 'required|unique:clients,name',
		'slug' => 'required|unique:clients,slug|slug'
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
	public static function rules(Client $client = null, $merge=[])
	{
		$rules = self::$rules;
		if ($client) {
			$rules = array_merge($rules, [
				'name' => 'required|unique:clients,name,'.$client->id,
				'slug' => 'slug|required|unique:clients,slug,'.$client->id,
			]);
		}

		return array_merge($rules, $merge);
	}

    public function isOwner(User $user)
    {
        return $this->owner_id == $user->id;
    }

    /**
     * @return bool
     */
    public function isUsergroupClient()
    {
        return Constants::getUsergroupClientId() == $this->id;
    }
    /*
	|--------------------------------------------------------------------------
	| Relationships
	|--------------------------------------------------------------------------
	*/
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function settings()
    {
        return $this->belongsTo(Settings\ClientSetting::class, 'client_id');
    }

    public function industries()
    {
        return $this->belongsToMany(Industry::class, 'client_industry');
    }

    public function administrator()
    {
        return $this->belongsTo(User::class, 'administrator_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function courses()
	{
		return $this->hasMany(Course::class);
	}

	public function modules()
	{
		return $this->hasManyThrough(Module::class, Course::class);
	}
    public function milestones()
    {
        return $this->hasMany(Milestone::class);
    }
    public function usergroups()
    {
        return $this->belongsToMany(Usergroup::class, 'client_usergroups', 'client_id', 'usergroup_id')
            ->withTimestamps();
    }
    public function innerUsergroups()
    {
        return $this->hasMany(ClientUsergroup::class);
    }

    public function buildings()
    {
        return $this->hasMany(Building::class);
    }

    public function rooms()
    {
        return $this->hasManyThrough(Room::class, Building::class);
    }

    public function roomAttributes()
    {
        return $this->hasMany(RoomAttribute::class);
    }

    public function theme()
    {
        return $this->belongsTo(Theme::class);
    }
    /*
	|--------------------------------------------------------------------------
	| Getters and Setters
	|--------------------------------------------------------------------------
	*/

    /**
     * Just to normalize the way we are loading the client_id field
     * from all the OwnsDiscussionGroupsInterface compliant classes
     *
     * @return int
     */
    public function getClientIdAttribute()
    {
        return $this->id;
    }
    /**
     * @return bool
     */
    public function hasEmergencyRoute()
    {
        return $this->emergency_route->originalFilename();
    }

    /*
	|--------------------------------------------------------------------------
	| Repo Methods
	|--------------------------------------------------------------------------
    | These methods may be moved to a repository later on in the development
    | cycle as needed.
	*/
    /**
     * @return \Codesleeve\Stapler\Attachment
     */
    public function getEmergencyRoute()
    {
        return $this->emergency_route;
    }
}