<?php
/**
 * Created by Justin McCombs.
 * Date: 10/2/15
 * Time: 3:18 PM
 */

namespace Pi\Clients\Courses;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Pi\Clients\Client;
use Pi\Clients\Courses\Actions\ArticleAction;
use Pi\Clients\Courses\Quizzes\Quiz;
use Pi\Clients\Courses\Services\ArticlesService;
use Pi\Utility\Assets\AssetableInterface;
use Pi\Utility\Assets\UsesAssets;
use Ramsey\Uuid\Uuid;

/**
 * Pi\Clients\Courses\Article
 *
 * @property integer $id
 * @property integer $client_id
 * @property integer $module_id
 * @property integer $number
 * @property string $name
 * @property string $body
 * @property string $published_at
 * @property string $uuid
 * @property string $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read Client $client
 * @property-read Module $module
 * @property-read \Illuminate\Database\Eloquent\Collection|Quiz[] $quizzes
 * @property-read Quiz $doQuiz
 * @property-read Quiz $answerQuiz
 * @property-read mixed $topics
 * @property-read \Illuminate\Database\Eloquent\Collection|self[] $previousVersions
 * @property-read \Illuminate\Database\Eloquent\Collection|Asset[] $assets
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Article whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Article whereClientId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Article whereModuleId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Article whereNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Article whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Article whereBody($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Article wherePublishedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Article whereUuid($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Article whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Article whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Article whereUpdatedAt($value)
 */
class Article extends \Eloquent implements AssetableInterface {

	use SoftDeletes, UsesAssets;
    
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
	public function client()
	{
		return $this->belongsTo(Client::class);
	}

	public function module()
	{
		return $this->belongsTo(Module::class);
	}

	public function actions()
	{
		return $this->hasMany(ArticleAction::class);
	}

	public function watchActions()
	{
		return $this->actions()->isWatch();
	}

	public function listenActions()
	{
		return $this->actions()->isListen();
	}

	public function quizzes()
	{
		return $this->hasMany(Quiz::class);
	}

	public function doQuiz()
	{
		return $this->hasOne(Quiz::class)->where('quizzes.type', Quiz::TYPE_DO);
	}

	public function answerQuiz()
	{
		return $this->hasOne(Quiz::class)->where('quizzes.type', Quiz::TYPE_ANSWER);
	}


    /*
	|--------------------------------------------------------------------------
	| Getters and Setters
	|--------------------------------------------------------------------------
	*/

    /**
     * @return Course
     */
    public function getCourse()
    {
        return $this->module->course;
    }

	public function getRenderedBodyAttribute()
	{
		$body = $this->body;
		$service = \App::make(ArticlesService::class);
		$body = $service->renderArticleContentBoxes($body);
		$body = $service->renderArticleTooltipBoxes($body);
		$body = $service->renderArticleTooltips($body);
		return $body;
	}

	public function getTopicsAttribute()
	{
		$service = \App::make(ArticlesService::class);
		return $service->getArticleSections($this);
	}

    /*
	|--------------------------------------------------------------------------
	| Repo Methods
	|--------------------------------------------------------------------------
    | These methods may be moved to a repository later on in the development
    | cycle as needed.
	*/

	public function createNewVersion(array $attributes = [], $save = true)
	{
		$articleAttributes = array_merge($this->toArray(), $attributes);
		unset($articleAttributes['id']);
		$articleAttributes['created_at'] = Carbon::now();
		$articleAttributes['updated_at'] = Carbon::now();
		$article = new Article($articleAttributes);

		if ($save)
		{
			$article->save();

			// Update quizzes, actions,

			$this->delete();
		}

		return $article;
	}

	public function previousVersions()
	{
		return $this->hasMany(self::class, 'uuid', 'uuid')
				->where('id', '<>', $this->id)
				->orderBy('created_at', 'desc')
				->withTrashed();
	}

}

Article::creating(function(Article $article) {
	if ( ! $article->number )
	{
		$lastArticle = $article->module->articles->last();
		if ($lastArticle) {
			$article->number = $lastArticle->number + 1;
		}else {
			$article->number = 1;
		}
	}

	if ( ! $article->uuid ) {
		$uuid = '';
		while (Article::whereUuid($uuid)->count()) {
			$uuid = Uuid::uuid4();
		}
		$article->uuid = $uuid;
	}



});