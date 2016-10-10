<?php

namespace Pi\DiscussionGroups;

use Illuminate\Database\Eloquent\SoftDeletes;
use Pi\Clients\Client;
use Pi\DiscussionGroups\DiscussionGroupPost as Post;

/**
 * Pi\DiscussionGroups\DiscussionGroupThread
 *
 * @property integer $id
 * @property integer $client_id
 * @property integer $discussion_group_id
 * @property integer $user_id
 * @property string $title
 * @property string $slug
 * @property boolean $hand_raised
 * @property string $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Pi\DiscussionGroups\DiscussionGroupPost[] $posts
 * @property-read \Pi\Auth\User $user
 * @property-read Client $client
 * @property-read Post $question
 * @property-read \Illuminate\Database\Eloquent\Collection|Post[] $answers
 * @property-read mixed $assets_count
 * @method static \Illuminate\Database\Query\Builder|\Pi\DiscussionGroups\DiscussionGroupThread whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\DiscussionGroups\DiscussionGroupThread whereClientId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\DiscussionGroups\DiscussionGroupThread whereDiscussionGroupId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\DiscussionGroups\DiscussionGroupThread whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\DiscussionGroups\DiscussionGroupThread whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\DiscussionGroups\DiscussionGroupThread whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\DiscussionGroups\DiscussionGroupThread whereHandRaised($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\DiscussionGroups\DiscussionGroupThread whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\DiscussionGroups\DiscussionGroupThread whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\DiscussionGroups\DiscussionGroupThread whereUpdatedAt($value)
 */
class DiscussionGroupThread extends \Eloquent
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
    public static function rules($id = null, $merge=[])
    {
        return array_merge(self::$rules, $merge);
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */
    public function posts()
    {
        return $this->hasMany('Pi\DiscussionGroups\DiscussionGroupPost');
    }

    public function user()
    {
        return $this->belongsTo('Pi\Auth\User');
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function question()
    {
        return $this->hasOne(Post::class)->where('type', '=', Post::TYPE_QUESTION);
    }

    public function answers()
    {
        return $this->hasMany(Post::class)->where('type', '=', Post::TYPE_ANSWER);
    }

    /*
    |--------------------------------------------------------------------------
    | Getters and Setters
    |--------------------------------------------------------------------------
    */

    /**
     * @return int
     */
    public function getAssetsCountAttribute()
    {
        $count = 0;
        $this->posts()->with('assets')->get()->each(function($item) use (&$count) {
            $count += $item->assets->count();
        });

        return $count;
    }

    /*
    |--------------------------------------------------------------------------
    | Repo Methods
    |--------------------------------------------------------------------------
    | These methods may be moved to a repository later on in the development
    | cycle as needed.
    */

}
