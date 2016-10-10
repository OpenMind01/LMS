<?php

namespace Pi\Domain\Industries;
use Pi\Domain\Model;
use Pi\Usergroups\Usergroup;

/**
 * Pi\Domain\Industries\Industry
 *
 * @property integer $id
 * @property string $title
 * @property boolean $ready
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|Usergroup[] $usergroups
 * @method static \Illuminate\Database\Query\Builder|\Pi\Domain\Industries\Industry whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Domain\Industries\Industry whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Domain\Industries\Industry whereReady($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Domain\Industries\Industry whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Domain\Industries\Industry whereUpdatedAt($value)
 */
class Industry extends Model
{
    public function usergroups()
    {
        return $this->belongsToMany(Usergroup::class, 'usergroup_industry', 'industry_id', 'usergroup_id');
    }
}