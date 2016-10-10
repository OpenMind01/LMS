<?php

namespace Pi\Usergroups;
use Pi\Clients\Courses\Module;

/**
 * Pi\Usergroups\UsergroupModule
 *
 * @property integer $id
 * @property integer $usergroup_id
 * @property integer $module_id
 * @property integer $number
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read Usergroup $usergroup
 * @property-read Module $module
 * @property-read \Illuminate\Database\Eloquent\Collection|UsergroupArticle[] $articles
 * @method static \Illuminate\Database\Query\Builder|\Pi\Usergroups\UsergroupModule whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Usergroups\UsergroupModule whereUsergroupId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Usergroups\UsergroupModule whereModuleId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Usergroups\UsergroupModule whereNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Usergroups\UsergroupModule whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Usergroups\UsergroupModule whereUpdatedAt($value)
 */
class UsergroupModule extends \Eloquent
{
    protected $table = 'usergroup_modules';

    public function usergroup()
    {
        return $this->belongsTo(Usergroup::class, 'usergroup_id');
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function articles()
    {
        return $this->hasMany(UsergroupArticle::class, 'usergroup_module_id');
    }

    protected static function boot() {
        parent::boot();

        static::deleting(function(UsergroupModule $usergroupModule) {
            $usergroupModule->articles()->delete();
        });
    }
}