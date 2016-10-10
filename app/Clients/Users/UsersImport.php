<?php

namespace Pi\Clients\Users;

use Pi\Domain\Model;

/**
 * Pi\Clients\Users\UserImport
 *
 * @property integer $id
 * @property integer $client_id
 * @property string $delimiter
 * @property string $csv
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Users\UsersImport whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Users\UsersImport whereClientId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Users\UsersImport whereDelimiter($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Users\UsersImport whereCsv($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Users\UsersImport whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Users\UsersImport whereUpdatedAt($value)
 */
class UsersImport extends Model
{

}