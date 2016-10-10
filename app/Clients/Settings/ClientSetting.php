<?php

namespace Pi\Clients\Settings;

use Pi\Domain\Model;

/**
 * Pi\Clients\Settings\ClientSetting
 *
 * @property integer $client_id
 * @property string $widget_settings
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Settings\ClientSetting whereClientId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Settings\ClientSetting whereWidgetSettings($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Settings\ClientSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Settings\ClientSetting whereUpdatedAt($value)
 */
class ClientSetting extends Model
{
    protected $primaryKey = 'client_id';

    protected $casts = [
        'widget_settings' => 'array',
    ];
}