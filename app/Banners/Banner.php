<?php
/**
 * Created by Justin McCombs.
 * Date: 10/14/15
 * Time: 12:06 PM
 */

namespace Pi\Banners;

use Pi\Auth\User;
use Pi\Clients\Client;

/**
 * Pi\Banners\Banner
 *
 * @property integer $id
 * @property integer $client_id
 * @property integer $created_by
 * @property string $style
 * @property string $icon
 * @property string $title
 * @property string $body
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read User $author
 * @property-read \Illuminate\Database\Eloquent\Collection|User[] $dismissedUsers
 * @property-read Client $client
 * @property-read mixed $seen_by_percent
 * @method static \Illuminate\Database\Query\Builder|\Pi\Banners\Banner whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Banners\Banner whereClientId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Banners\Banner whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Banners\Banner whereStyle($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Banners\Banner whereIcon($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Banners\Banner whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Banners\Banner whereBody($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Banners\Banner whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Banners\Banner whereUpdatedAt($value)
 */
class Banner extends \Eloquent {
    
    protected $guarded = ['id'];

    public static $rules = [
		'client_id' => 'required|integer',
		'created_by' => 'required|integer',
		'style' => 'required|string|in:success,danger,warning,info,primary',
		'title' => 'string|max:255',
		'body' => 'required|max:500'
    ];

	public static $styles = [
		'info' => 'Info (light blue)',
		'primary' => 'Primary (dark blue)',
		'success' => 'Success (green)',
		'warning' => 'Warning (orange)',
		'danger' => 'Danger (red)',
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
	public function author()
	{
		return $this->belongsTo(User::class, 'created_by');
	}
	public function dismissedUsers()
	{
		return $this->belongsToMany(User::class)->withTimestamps();
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
	public function getSeenByPercentAttribute()
	{
		$clientUserCount = $this->client->users()->count();
		$seenByCount = $this->dismissedUsers->count();
		if ( $clientUserCount == 0 ) return 0;
		return round($seenByCount/$clientUserCount, 2)*100;
	}

    /*
	|--------------------------------------------------------------------------
	| Repo Methods
	|--------------------------------------------------------------------------
    | These methods may be moved to a repository later on in the development
    | cycle as needed.
	*/

}