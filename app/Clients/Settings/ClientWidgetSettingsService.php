<?php

namespace Pi\Clients\Settings;

use Pi\Clients\Client;

class ClientWidgetSettingsService
{
    /**
     * @param Client $client
     * @return array
     */
    public function get(Client $client)
    {
        $clientSetting = ClientSetting::find($client->id);

        if($clientSetting == null)
        {
            return [];
        }

        return $clientSetting->widget_settings;
    }

    /**
     * @param Client $client
     * @param array $widgetSettings
     */
    public function store(Client $client, array $widgetSettings)
    {
        $clientSetting = ClientSetting::find($client->id);

        if($clientSetting == null)
        {
            $clientSetting = new ClientSetting();
            $clientSetting->client_id = $client->id;
        }

        $clientSetting->widget_settings = $widgetSettings;
        $clientSetting->save();
    }
}