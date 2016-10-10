<?php
/**
 * Created by Justin McCombs.
 * Date: 12/22/15
 * Time: 2:21 PM
 */

namespace Pi\Clients\Courses\Actions;


use Codesleeve\Stapler\ORM\EloquentTrait;
use Codesleeve\Stapler\ORM\StaplerableInterface;
use Illuminate\Database\Eloquent\SoftDeletes;
use Pi\Auth\User;
use Pi\Clients\Courses\Article;

class ArticleAction extends \Eloquent implements StaplerableInterface {

    use EloquentTrait;

    protected $guarded = ['id'];

    public static $userPivotFields = ['completion_percent'];

    public static $rules = [
        'client_id' => 'required|integer',
        'article_id' => 'required|integer',
        'type_id' => 'required|integer',
        'title' => 'required|string',
        'description' => 'string',
//        'file' => 'required_if:type_id,2',
        'url' => 'required_if:type_id,1',
    ];

    const TYPE_YOUTUBE = 1;
    const TYPE_AUDIO = 2;
    public static $types = [
        self::TYPE_YOUTUBE => 'Youtube',
        self::TYPE_AUDIO => 'Audio',
    ];

    public function __construct(array $attributes = [])
    {
        $this->hasAttachedFile('file');

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
    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'article_action_user')->withTimestamps()->withPivot(self::$userPivotFields);
    }


    /*
	|--------------------------------------------------------------------------
	| Getters and Setters
	|--------------------------------------------------------------------------
	*/
    public function getUrlAttribute()
    {
        if ($this->file_file_name)
            return $this->file->url();

        return $this->attributes['url'];
    }

    public function getRealUrlAttribute()
    {
        return $this->attributes['url'];
    }

    public function getTypeName()
    {
        return (array_key_existss($this->type_id, self::$types)) ? self::$types[$this->type_id] : 'Unknown';
    }

    /*
	|--------------------------------------------------------------------------
	| DB Scopes
	|--------------------------------------------------------------------------
	*/
    public function scopeIsWatch($query) {
        return $query->where('article_actions.type_id', '=', self::TYPE_YOUTUBE);
    }

    public function scopeIsListen($query) {
        return $query->where('article_actions.type_id', '=', self::TYPE_AUDIO);
    }


    /*
	|--------------------------------------------------------------------------
	| Repo Methods
	|--------------------------------------------------------------------------
    | These methods may be moved to a repository later on in the development
    | cycle as needed.
	*/

}