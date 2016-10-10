<?php
/**
 * Created by Justin McCombs.
 * Date: 10/2/15
 * Time: 3:18 PM
 */

namespace Pi\Clients\Resources;


use Codesleeve\Stapler\ORM\EloquentTrait;
use Codesleeve\Stapler\ORM\StaplerableInterface;
use Illuminate\Database\Eloquent\SoftDeletes;
use Pi\Clients\Client;

/**
 * Pi\Clients\Resources\Resource
 *
 * @property integer $id
 * @property integer $client_id
 * @property integer $resourceable_id
 * @property string $resourceable_type
 * @property string $name
 * @property string $type
 * @property string $description
 * @property string $url
 * @property string $file_file_name
 * @property integer $file_file_size
 * @property string $file_content_type
 * @property string $file_updated_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read Client $client
 * @property-read \ $resourceable
 * @property-read mixed $type_name
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Resources\Resource whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Resources\Resource whereClientId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Resources\Resource whereResourceableId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Resources\Resource whereResourceableType($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Resources\Resource whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Resources\Resource whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Resources\Resource whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Resources\Resource whereUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Resources\Resource whereFileFileName($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Resources\Resource whereFileFileSize($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Resources\Resource whereFileContentType($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Resources\Resource whereFileUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Resources\Resource whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Resources\Resource whereUpdatedAt($value)
 */
class Resource extends \Eloquent implements StaplerableInterface {

    use EloquentTrait;
    
    protected $guarded = ['id'];

    protected $appends = ['type_name'];

    public static $rules = [
        'client_id' => 'required|integer',
        'name' => 'required',
        'type' => 'required|in:1,2,3,4'
    ];

    const TYPE_IMAGE = 1;
    const TYPE_LINK = 2;
    const TYPE_AUDIO = 3;
    const TYPE_VIDEO = 4;
    const TYPE_YOUTUBE = 5;

    public static $types = [
        self::TYPE_IMAGE => 'Image',
        self::TYPE_LINK => 'Link',
        self::TYPE_AUDIO => 'Audio',
        self::TYPE_VIDEO => 'Video',
        self::TYPE_YOUTUBE => 'YouTube',
    ];

    public static $type_icon = [
        self::TYPE_IMAGE => 'fa-file-image-o',
        self::TYPE_LINK => 'fa-link',
        self::TYPE_AUDIO => 'fa-file-audio-o',
        self::TYPE_VIDEO => 'fa-youtube-play',
        self::TYPE_YOUTUBE => 'fa-youtube',
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
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function resourceable()
    {
        return $this->morphTo();
    }

    /*
	|--------------------------------------------------------------------------
	| Getters and Setters
	|--------------------------------------------------------------------------
	*/
    public function getTypeNameAttribute()
    {
        if (array_key_exists($this->type, self::$types)) return self::$types[$this->type];
        return 'Unknown';
    }

    public function getUrlAttribute($value)
    {
        if ( in_array($this->type, [self::TYPE_LINK, self::TYPE_YOUTUBE]))
        {
            return $value;
        }

        if ( ! $this->file_file_name)
        {
            return $value;
        }

        return $this->file->url();
    }

    public function getTypeIconAttribute($value)
    {
        if (array_key_exists($this->type, self::$type_icon)) return self::$type_icon[$this->type];

    }


    public function newCollection(array $models = [])
    {
        return new ResourceCollection($models);
    }

    /*
	|--------------------------------------------------------------------------
	| Repo Methods
	|--------------------------------------------------------------------------
    | These methods may be moved to a repository later on in the development
    | cycle as needed.
	*/

}