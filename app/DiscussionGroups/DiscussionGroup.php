<?php
/**
 * Created by Justin McCombs.
 * Date: 11/11/15
 * Time: 9:31 AM
 */

namespace Pi\DiscussionGroups;


use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Pi\DiscussionGroups\DiscussionGroup
 *
 * @property integer $id
 * @property integer $client_id
 * @property integer $parent_discussion_group_id
 * @property integer $discussionable_id
 * @property string $discussionable_type
 * @property string $title
 * @property string $slug
 * @property string $description
 * @property string $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \ $discussionable
 * @property-read \Illuminate\Database\Eloquent\Collection|\Pi\DiscussionGroups\DiscussionGroupThread[] $threads
 * @method static \Illuminate\Database\Query\Builder|\Pi\DiscussionGroups\DiscussionGroup whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\DiscussionGroups\DiscussionGroup whereClientId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\DiscussionGroups\DiscussionGroup whereParentDiscussionGroupId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\DiscussionGroups\DiscussionGroup whereDiscussionableId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\DiscussionGroups\DiscussionGroup whereDiscussionableType($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\DiscussionGroups\DiscussionGroup whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\DiscussionGroups\DiscussionGroup whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\DiscussionGroups\DiscussionGroup whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\DiscussionGroups\DiscussionGroup whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\DiscussionGroups\DiscussionGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\DiscussionGroups\DiscussionGroup whereUpdatedAt($value)
 */
class DiscussionGroup extends \Eloquent
{

    use SoftDeletes;

    protected $guarded = ['id'];

    public static $rules = [

    ];

    /*
	|--------------------------------------------------------------------------
	| Rules
	|--------------------------------------------------------------------------
	*/
    public static function rules($id = null, $merge = [])
    {
        return array_merge(self::$rules, $merge);
    }


    /*
	|--------------------------------------------------------------------------
	| Relationships
	|--------------------------------------------------------------------------
	*/
    public function discussionable()
    {
        return $this->morphTo();
    }

    public function threads()
    {
        return $this->hasMany('Pi\DiscussionGroups\DiscussionGroupThread');
    }

    /*
	|--------------------------------------------------------------------------
	| Getters and Setters
	|--------------------------------------------------------------------------
	*/
    public function getRouteParameters($defaultParameters = [], $extraParameters = [])
    {
        $defaultParameters[] = $this->slug;

        return $defaultParameters;
    }

    /*
	|--------------------------------------------------------------------------
	| Repo Methods
	|--------------------------------------------------------------------------
    | These methods may be moved to a repository later on in the development
    | cycle as needed.
	*/
}
