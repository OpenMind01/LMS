<?php
/**
 * Created by Justin McCombs.
 * Date: 9/29/15
 * Time: 9:21 AM
 */

namespace Pi\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Guard;
use Pi\Clients\Schedule\AdministratorScheduleService;
use Pi\Services\GoogleCalendar;
use Illuminate\Http\Request;
use Cache;


class DashboardController extends Controller
{

    public function index(Guard $auth, GoogleCalendar $calendar, AdministratorScheduleService $administratorScheduleService)
    {
        $viewArgs = [];

        if ($auth->user()->isAdmin() && !$auth->user()->hasGoogleToken())
        {
            $viewArgs['askForToken'] = true;

            $client = $calendar->createClient();
            $client->setRedirectUri(action('DashboardController@setGoogleToken'));
            $viewArgs['authUrl'] = $client->createAuthUrl();
        }
        else
        {
            $viewArgs['askForToken'] = false;

        }

        return view('pages.dashboard', $viewArgs);

    }

    /**
     * Gets the Google permission token to retrieve calendar events
     *
     * @param Request $request
     * @param Guard $auth
     * @param GoogleCalendar $calendar
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function setGoogleToken(Request $request, Guard $auth, GoogleCalendar $calendar)
    {
        if ($request->has('code'))
        {
            $client = $calendar->createClient();
            $client->setRedirectUri(action('DashboardController@setGoogleToken'));
            $client->authenticate($request->get('code'));

            $accessToken = $client->getAccessToken();

            $token = json_decode($accessToken, true);

            if(!isset($token['refresh_token']))
            {
                return redirect()->action('DashboardController@index')->with('refresh_token_error', 1);
            }

            $auth->user()->google_token = $accessToken;
            $auth->user()->save();
        }

        return redirect()->action('DashboardController@index')->with('message', ['success', 'Token has been successfully taken']);
    }
}