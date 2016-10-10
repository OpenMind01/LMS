<?php
/**
 * Created by Justin McCombs.
 * Date: 10/2/15
 * Time: 3:17 PM
 */

namespace Pi\Clients\Courses;

use Illuminate\Database\Eloquent\Model;
use Pi\DiscussionGroups\Interfaces\OwnsDiscussionGroupsInterface;
use Illuminate\Database\Eloquent\SoftDeletes;
use Pi\Auth\User;
use Pi\Clients\Client;
use Pi\Helpers\SlugHelper;
use Pi\DiscussionGroups\Traits\OwnsDiscussionGroups;
use Pi\Snippets\Interfaces\UsedInSnippetsInterface;
use Pi\Utility\Assets\AssetableInterface;
use Pi\Utility\Assets\UsesAssets;

/**
 * Pi\Clients\Courses\Course
 *
 * @property integer $id
 * @property integer $client_id
 * @property integer $number
 * @property string $description
 * @property string $name
 * @property string $slug
 * @property string $published_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $type
 * @property-read Client $client
 * @property-read \Illuminate\Database\Eloquent\Collection|Module[] $modules
 * @property-read \Illuminate\Database\Eloquent\Collection|User[] $users
 * @property-read \Illuminate\Database\Eloquent\Collection|DiscussionGroup[] $discussionGroups
 * @property-read \Illuminate\Database\Eloquent\Collection|Asset[] $assets
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Course whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Course whereClientId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Course whereNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Course whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Course whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Course whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Course wherePublishedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Course whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Course whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Course whereType($value)
 */


//}
class Course extends \Eloquent implements OwnsDiscussionGroupsInterface, AssetableInterface, UsedInSnippetsInterface {

    use UsesAssets, OwnsDiscussionGroups;
    const TYPE_CLIENT = 'client'; // Usual client course
    const TYPE_USERGROUP = 'usergroup'; // Course based on usergroup

    protected $guarded = ['id'];

	public static $userPivot = [
		'passed', 'progress_percent', 'progress', 'current_article_id', 'read_articles'
	];

    public static $rules = [
		'client_id' => 'integer|required',
		'number' => 'integer',
		'name' => 'required',
    ];
    
    /*
	|--------------------------------------------------------------------------
	| Rules
	|--------------------------------------------------------------------------
	*/
	/**
	 * @param null $id
	 * @param null $clientId
	 * @param array $merge
	 * @return array
	 */
	public static function rules($id = null, $clientId = null, $merge=[])
	{
//		if ($id && $clientId)
//		{
//			$merge['slug'] = 'required|slug|unique:courses,slug,'.$id.',id,client_id,'.$clientId;
//		}else {
//			$merge['slug'] = 'required|slug|unique:courses,slug,NULL,id,client_id,'. $clientId;
//		}
		$rules = array_merge(self::$rules, $merge);

		return $rules;
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

    public function modules()
	{
		return $this->hasMany(Module::class)->orderBy('number', 'asc');
	}

	public function articles()
	{
		return $this->hasManyThrough(Article::class, Module::class);
	}

    public function users()
    {
        return $this->belongsToMany(User::class, 'course_users')->withTimestamps()->withPivot(self::$userPivot);
    }

	/*
    |--------------------------------------------------------------------------
    | Getters and Setters
    |--------------------------------------------------------------------------
    */

	/*
	|--------------------------------------------------------------------------
	| Eloquent Overrides
	|--------------------------------------------------------------------------
	*/
	/**
	 * Create a new pivot model instance.
	 *
	 * @param  \Illuminate\Database\Eloquent\Model  $parent
	 * @param  array  $attributes
	 * @param  string  $table
	 * @param  bool  $exists
	 * @return \Illuminate\Database\Eloquent\Relations\Pivot
	 */
	public function newPivot(Model $parent, array $attributes, $table, $exists)
	{
		if (get_class($parent) === User::class) {
			return new CourseUserPivot($parent, $attributes, $table, $exists);
		}
		return new Pivot($parent, $attributes, $table, $exists);
	}


	/*
    |--------------------------------------------------------------------------
    | Repo Methods
    |--------------------------------------------------------------------------
    | These methods may be moved to a repository later on in the development
    | cycle as needed.
    */

}
Course::creating(function(Course $course) {
	$course->slug = SlugHelper::generate($course->name, $course->client->courses()->lists('slug')->toArray());
});
