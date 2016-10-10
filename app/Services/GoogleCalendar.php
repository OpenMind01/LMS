<?php namespace Pi\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class GoogleCalendar
{
    /**
     * Creates the google client object
     *
     * @return \Google_Client
     */
    public function createClient()
    {
        $scopes = implode(' ', [\Google_Service_Calendar::CALENDAR]);

        $client = new \Google_Client();
        $client->setApplicationName('P4 LMS');
        $client->setScopes($scopes);
        $client->setClientId(env('GOOGLE_API_ID'));
        $client->setClientSecret(env('GOOGLE_API_SECRET'));
        $client->setAccessType('offline');

        return $client;
    }

    /**
     * Creates a Google calendar service. Required clients access token.
     *
     * @param string $accessToken
     * @return \Google_Service_Calendar
     */
    public function createCalendarService($accessToken)
    {
        $client = $this->createClient();
        $client->setAccessToken($accessToken);

        return new \Google_Service_Calendar($client);
    }
}