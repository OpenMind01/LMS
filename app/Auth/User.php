<?php

namespace Pi\Auth;

use Codesleeve\Stapler\ORM\EloquentTrait;
use Codesleeve\Stapler\ORM\StaplerableInterface;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Pi\Banners\Banner;
use Pi\Clients\Client;
use Pi\Clients\Courses\Actions\ArticleAction;
use Pi\Clients\Courses\Course;
use Pi\Clients\Courses\CourseUserPivot;
use Pi\Clients\Locations\Rooms\Room;
use Pi\Clients\Milestones\Milestone;
use Pi\Clients\Usergroups\ClientUsergroup;
use Pi\Domain\ValueObjects\Address;
use Pi\Clients\Courses\Quizzes\QuizAttempt;
use Pi\Clients\Courses\Quizzes\QuizElementResponse;
use Pi\Snippets\Interfaces\UsedInSnippetsInterface;
use Pi\Usergroups\Usergroup;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Pi\DiscussionGroups\DiscussionGroupPost as Post;
use Illuminate\Foundation\Auth\Access\Authorizable;

/**
 * Pi\Auth\User
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $first_name
 * @property string $last_name
 * @property string $phone_mobile
 * @property string $phone_home
 * @property string $phone_work
 * @property string $address_street
 * @property string $address_street_2
 * @property string $address_city
 * @property string $address_state
 * @property string $address_postal
 * @property string $address_country
 * @property integer $current_client_id
 * @property string $avatar_file_name
 * @property integer $avatar_file_size
 * @property string $avatar_content_type
 * @property string $avatar_updated_at
 * @property integer $client_usergroup_id
 * @property string $role
 * @property integer $client_id
 * @property boolean $active
 * @property integer $room_id
 * @property string $google_token
 * @property-read Client $client
 * @property-read \Illuminate\Database\Eloquent\Collection|Banner[] $dismissedBanners
 * @property-read \Illuminate\Database\Eloquent\Collection|Milestone[] $milestones
 * @property-read ClientUsergroup $usergroup
 * @property-read \Illuminate\Database\Eloquent\Collection|QuizAttempt[] $quizAttempts
 * @property-read \Illuminate\Database\Eloquent\Collection|QuizElementResponse[] $quizElementResponses
 * @property-read \Illuminate\Database\Eloquent\Collection|Course[] $courses
 * @property-read Room $room
 * @property-read \Illuminate\Database\Eloquent\Collection|Post[] $questions
 * @property-read \Illuminate\Database\Eloquent\Collection|Post[] $answers
 * @property-read mixed $full_name
 * @method static \Illuminate\Database\Query\Builder|\Pi\Auth\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Auth\User whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Auth\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Auth\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Auth\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Auth\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Auth\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Auth\User whereFirstName($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Auth\User whereLastName($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Auth\User wherePhoneMobile($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Auth\User wherePhoneHome($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Auth\User wherePhoneWork($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Auth\User whereAddressStreet($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Auth\User whereAddressStreet2($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Auth\User whereAddressCity($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Auth\User whereAddressState($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Auth\User whereAddressPostal($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Auth\User whereAddressCountry($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Auth\User whereCurrentClientId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Auth\User whereAvatarFileName($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Auth\User whereAvatarFileSize($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Auth\User whereAvatarContentType($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Auth\User whereAvatarUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Auth\User whereClientUsergroupId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Auth\User whereRole($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Auth\User whereClientId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Auth\User whereActive($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Auth\User whereRoomId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Auth\User whereGoogleToken($value)
 */
class User extends \Eloquent implements AuthenticatableContract,
                                    //AuthorizableContract,
                                    CanResetPasswordContract,
                                    StaplerableInterface,
                                    UsedInSnippetsInterface
{
    use Authenticatable, CanResetPassword, Authorizable;
    //use EntrustUserTrait { EntrustUserTrait::boot insteadof EloquentTrait; }
    use EloquentTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id', 'password', 'repeat_password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    protected $appends = ['full_name'];

    public static $rules = [
        'first_name' => 'required',
        'last_name' => 'required',
        'email' => 'email|required|unique:users,email'
    ];

    public static function rules($id = null)
    {
        $rules = [];

        if ($id)
        {
            $rules['email'] = 'required|email|unique:users,email,';
            $rules['client'] = 'required';
            $rules['course'] = 'required';
        }

        return array_merge(self::$rules, $rules);
    }

    public function __construct(array $attributes = [])
    {
        $this->hasAttachedFile('avatar', [
            'styles' => [
                'medium' => '500x500',
                'thumb' => '100x100',
            ]
        ]);

        parent::__construct($attributes);
    }

    public static function boot()
    {
        parent::boot();
//        static::boot();
        static::bootStapler();
    }

    /*
    |--------------------------------------------------------------------------
    | Roles
    |--------------------------------------------------------------------------
    */
    public function isSuperAdmin()
    {
        return $this->role == Role::SUPER_ADMIN || $this->role == Role::ADMIN; // temporarily added ADMIN here.
    }

    public function isAdmin(Client $client = null)
    {
        if($client == null) {
            return in_array($this->role, [Role::ADMIN, Role::SUPER_ADMIN]);
        }

        return $this->isSuperAdmin() || $this->role == Role::ADMIN && $this->client_id == $client->id;
    }

    /**
     * Returns true if this user can moderate this client courses, users, etc.
     *
     * @param Client $client
     * @return bool
     */
    public function isModerator(Client $client = null)
    {
        if($client == null) {
            return in_array($this->role, [Role::MODERATOR, Role::ADMIN, Role::SUPER_ADMIN]);
        }

        return ($this->role == Role::MODERATOR && $this->client_id == $client->id) ||
            $this->isAdmin($client);
    }

    public function isStudent() {
        return in_array($this->role, [Role::MODERATOR, Role::ADMIN, Role::SUPER_ADMIN, Role::STUDENT]);
    }

    /**
     * @return bool
     */
    public function hasClient()
    {
        return $this->client != null;
    }

    public function hasGoogleToken()
    {
        return $this->google_token != null;
    }

    public function getLastLoginAttribute()
    {
       return $this->logged_in;
    }

    public function getLastLogoutAttribute()
    {
        return $this->logged_out;
    }


    public function getLoginStatusAttribute()
    {
        return $this->logged_in > $this->logged_out;
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

    public function dismissedBanners()
    {
        return $this->belongsToMany(Banner::class)->withTimestamps();
    }

    public function milestones()
    {
        return $this->belongsToMany(Milestone::class, 'milestone_user')->withTimestamps();
    }

    public function usergroup()
    {
        return $this->belongsTo(ClientUsergroup::class, 'client_usergroup_id');
    }

    public function quizAttempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }

    public function quizElementResponses()
    {
        return $this->hasMany(QuizElementResponse::class);
    }

    public function articleActions()
    {
        return $this->belongsToMany(ArticleAction::class, 'article_action_user')->withTimestamps()->withPivot(ArticleAction::$userPivotFields);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_users')
            ->with(['client' => function($q) {
                $q->select('id', 'slug');
            }])
            ->withPivot(Course::$userPivot)->withTimestamps();
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function questions()
    {
        return $this->hasMany(Post::class)->where('type', '=', Post::TYPE_QUESTION);
    }

    public function answers()
    {
        return $this->hasMany(Post::class)->where('type', '=', Post::TYPE_ANSWER);
    }


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
        if (get_class($parent) === Course::class) {
            return new CourseUserPivot($parent, $attributes, $table, $exists);
        }
        return new Pivot($parent, $attributes, $table, $exists);
    }


    /*
	|--------------------------------------------------------------------------
	| Getters and Setters
	|--------------------------------------------------------------------------
	*/
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * @return Address
     */
    public function getAddress()
    {
        return new Address(
            $this->address_country,
            $this->address_street,
            $this->address_street_2,
            $this->address_city,
            $this->address_state,
            $this->address_postal);
    }

    public function setAddress(Address $address)
    {
        $this->address_country = $address->getCountry();
        $this->address_street = $address->getStreet();
        $this->address_street_2 = $address->getStreet2();
        $this->address_city = $address->getCity();
        $this->address_state = $address->getState();
        $this->address_postal = $address->getPostal();
    }
}
