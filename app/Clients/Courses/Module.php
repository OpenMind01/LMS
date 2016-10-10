<?php
/**
 * Created by Justin McCombs.
 * Date: 10/2/15
 * Time: 3:18 PM
 */

namespace Pi\Clients\Courses;


use Codesleeve\Stapler\ORM\EloquentTrait;
use Codesleeve\Stapler\ORM\StaplerableInterface;
use Pi\Clients\Client;
use Pi\Helpers\SlugHelper;
use Pi\DiscussionGroups\Interfaces\OwnsDiscussionGroupsInterface;
use Pi\DiscussionGroups\Traits\OwnsDiscussionGroups;
use Pi\Snippets\Interfaces\UsedInSnippetsInterface;
use Pi\Utility\Assets\AssetableInterface;
use Pi\Utility\Assets\UsesAssets;

/**
 * Pi\Clients\Courses\Module
 *
 * @property integer $id
 * @property integer $client_id
 * @property integer $course_id
 * @property integer $number
 * @property string $name
 * @property string $slug
 * @property string $published_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read Client $client
 * @property-read Course $course
 * @property-read \Illuminate\Database\Eloquent\Collection|Article[] $articles
 * @property-read \Illuminate\Database\Eloquent\Collection|Asset[] $assets
 * @property-read \Illuminate\Database\Eloquent\Collection|DiscussionGroup[] $discussionGroups
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Module whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Module whereClientId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Module whereCourseId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Module whereNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Module whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Module whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Module wherePublishedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Module whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Module whereUpdatedAt($value)
 */
class Module extends \Eloquent implements StaplerableInterface, AssetableInterface, OwnsDiscussionGroupsInterface, UsedInSnippetsInterface {

	use EloquentTrait, UsesAssets, OwnsDiscussionGroups;

    protected $guarded = ['id'];

    public static $rules = [
		'name' => 'required',
    ];

	public function __construct(array $attributes = [])
	{
		parent::__construct($attributes);
	}

    /*
	|--------------------------------------------------------------------------
	| Rules
	|--------------------------------------------------------------------------
	*/
	public static function rules(Module $module = null, Course $course = null, $merge=[])
	{
//		if ($module) {
//			$merge['slug'] = 'required|slug|unique:modules,slug,'.$module->id.',id,course_id,'.$module->course_id;
//		}
//		elseif($course) {
//			$merge['slug'] = 'required|slug|unique:modules,slug,NULL,id,course_id,'.$course->id;
//		}
//		else {
//			$merge['slug'] = 'required|slug|unique:modules,slug';
//		}

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

	public function course()
	{
		return $this->belongsTo(Course::class);
	}

	public function articles()
	{
		return $this->hasMany(Article::class)->orderBy('number', 'asc');
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

Module::creating(function(Module $module) {
	if ( ! $module->client_id )
		$module->client_id = $module->course->client_id;

	// Slug Creation
    $module->slug = SlugHelper::generate($module->name, $module->course->modules()->lists('slug')->toArray());
});
