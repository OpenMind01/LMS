<?php
/**
 * Created by Justin McCombs.
 * Date: 10/20/15
 * Time: 12:14 PM
 */

namespace Pi\Utility\Assets;

use Pi\Clients\Client;

/**
 * Pi\Utility\Assets\Asset
 *
 * @property integer $id
 * @property integer $client_id
 * @property integer $assetable_id
 * @property string $assetable_type
 * @property string $path
 * @property string $type
 * @property string $caption
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \assetable $assetable
 * @property-read Client $client
 * @method static \Illuminate\Database\Query\Builder|\Pi\Utility\Assets\Asset whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Utility\Assets\Asset whereClientId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Utility\Assets\Asset whereAssetableId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Utility\Assets\Asset whereAssetableType($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Utility\Assets\Asset wherePath($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Utility\Assets\Asset whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Utility\Assets\Asset whereCaption($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Utility\Assets\Asset whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Utility\Assets\Asset whereUpdatedAt($value)
 */
class Asset extends \Eloquent {

    protected $guarded = ['id'];

    public static $rules = [
        'client_id' => 'required|integer',
        'path' => 'required',
        'type' => 'required'
    ];

    public static $types = [
        'image' => 'Image',
        'document' => 'Document',
        'video' => 'Video',
        'sound' => 'Sound',
    ];
    
    /*
	|--------------------------------------------------------------------------
	| Rules
	|--------------------------------------------------------------------------
	*/
	public static function rules($id = null, $merge=[])
	{
        $rules = self::$rules;
        $rules['type'] = 'required|in:'.implode(',', array_keys(self::$types));
		return array_merge(self::$rules, $merge);
	}
    

    /*
	|--------------------------------------------------------------------------
	| Relationships
	|--------------------------------------------------------------------------
	*/
    public function assetable()
    {
        return $this->morphTo('assetable');
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /*
	|--------------------------------------------------------------------------
	| Getters and Setters
	|--------------------------------------------------------------------------
	*/

    /*
	|--------------------------------------------------------------------------
	| Scope
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
