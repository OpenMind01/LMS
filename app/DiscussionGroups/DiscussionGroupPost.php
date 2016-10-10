<?php
/**
 * Created by PhpStorm.
 * User: yefb
 * Date: 11/12/15
 * Time: 12:31 PM
 */

namespace Pi\DiscussionGroups;


use Illuminate\Database\Eloquent\SoftDeletes;
use Pi\Utility\Assets\AssetableInterface;
use Pi\Utility\Assets\UsesAssets;

/**
 * Pi\DiscussionGroups\DiscussionGroupPost
 *
 * @property integer $id
 * @property integer $client_id
 * @property integer $discussion_group_thread_id
 * @property integer $user_id
 * @property string $body
 * @property string $type
 * @property string $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Pi\Auth\User $user
 * @property-read \Pi\DiscussionGroups\DiscussionGroupThread $thread
 * @property-read \Illuminate\Database\Eloquent\Collection|Asset[] $assets
 * @method static \Illuminate\Database\Query\Builder|\Pi\DiscussionGroups\DiscussionGroupPost whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\DiscussionGroups\DiscussionGroupPost whereClientId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\DiscussionGroups\DiscussionGroupPost whereDiscussionGroupThreadId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\DiscussionGroups\DiscussionGroupPost whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\DiscussionGroups\DiscussionGroupPost whereBody($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\DiscussionGroups\DiscussionGroupPost whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\DiscussionGroups\DiscussionGroupPost whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\DiscussionGroups\DiscussionGroupPost whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\DiscussionGroups\DiscussionGroupPost whereUpdatedAt($value)
 */
class DiscussionGroupPost extends \Eloquent
    implements AssetableInterface
{

    const TYPE_QUESTION = 'question';

    const TYPE_ANSWER = 'answer';

    use SoftDeletes;

    use UsesAssets;

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
    public function user()
    {
        return $this->belongsTo('Pi\Auth\User');
    }

    public function thread()
    {
        return $this->belongsTo('Pi\DiscussionGroups\DiscussionGroupThread', 'discussion_group_thread_id');
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
