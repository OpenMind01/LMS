<?php

namespace Pi\Usergroups;
use Pi\Clients\Courses\Article;

/**
 * Pi\Usergroups\UsergroupArticle
 *
 * @property integer $id
 * @property integer $usergroup_module_id
 * @property integer $article_id
 * @property integer $number
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read UsergroupModule $usergroupModule
 * @property-read Article $article
 * @method static \Illuminate\Database\Query\Builder|\Pi\Usergroups\UsergroupArticle whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Usergroups\UsergroupArticle whereUsergroupModuleId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Usergroups\UsergroupArticle whereArticleId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Usergroups\UsergroupArticle whereNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Usergroups\UsergroupArticle whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Usergroups\UsergroupArticle whereUpdatedAt($value)
 */
class UsergroupArticle extends \Eloquent
{
    protected $table = 'usergroup_articles';

    public function usergroupModule()
    {
        return $this->belongsTo(UsergroupModule::class, 'usergroup__module_id');
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}